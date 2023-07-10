<?php

namespace App\Http\Controllers;

use App\Http\JsonResponse;
use App\Models\Book;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Slim\Psr7\Request;

class BookController
{
    public function index(Request $request): JsonResponse
    {
        $queryParams = $request->getQueryParams();

        $books = Book::query();

        if ($search = Arr::get($queryParams, 'search')) {
            $books->where(function (Builder $query) use ($search) {
                $query
                    ->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('author', 'LIKE', "%{$search}%");
            });
        }

        if ($sortField = Arr::get($queryParams, 'sortField')) {
            $direction = Arr::get($queryParams, 'sortOrder', 'asc');
            $books->orderBy($sortField, $direction);
        } else {
            $books->orderBy('id', 'desc');
        }

        return new JsonResponse($books->paginate());
    }

    public function show(Request $request): JsonResponse
    {
        /** @var Book $book */
        $book = Book::findOrFail((int)$request->getAttribute('id'));

        return new JsonResponse($book);
    }

    public function store(Request $request): JsonResponse
    {
        $book = new Book;

        $params = $request->getParsedBody();

        $book->title = $params['title'] ?? '';
        $book->author = $params['author'] ?? '';
        $book->publication_year = $params['publication_year'] ?? '';
        $book->genre = $params['genre'] ?? '';

        $book->save();

        return new JsonResponse($book, StatusCodeInterface::STATUS_CREATED);
    }

    public function update(Request $request): JsonResponse
    {
        /** @var Book $book */
        $book = Book::findOrFail((int)$request->getAttribute('id'));

        $params = $request->getParsedBody();

        $book->title = $params['title'] ?? '';
        $book->author = $params['author'] ?? '';
        $book->publication_year = $params['publication_year'] ?? '';
        $book->genre = $params['genre'] ?? '';

        $book->save();

        return new JsonResponse($book);
    }

    public function destroy(Request $request): JsonResponse
    {
        /** @var Book $book */
        $book = Book::findOrFail((int)$request->getAttribute('id'));
        $book->delete();

        return new JsonResponse([
            'success' => true
        ]);
    }
}
