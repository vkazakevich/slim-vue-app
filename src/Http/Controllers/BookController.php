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
    /**
     * Gets a list of books
     *
     * @OA\Get(
     *     path="/api/books",
     *     tags={"books"},
     *
     *     @OA\Parameter(
     *       name="page",
     *       in="query",
     *       description="Page",
     *       @OA\Schema(type="integer", default=1)
     *     ),
     *
     *     @OA\Parameter(
     *       name="search",
     *       in="query",
     *       description="Search phrase text",
     *       @OA\Schema(type="string", default="")
     *     ),
     *
     *     @OA\Parameter(
     *       name="sortField",
     *       in="query",
     *       description="Sort by field name",
     *       @OA\Schema(type="string", default="id")
     *     ),
     *
     *     @OA\Parameter(
     *       name="sortOrder",
     *       in="query",
     *       description="Sort direction",
     *       @OA\Schema(type="string", default="desc")
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="json"
     *     )
     * )
     */
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
            $direction = Arr::get($queryParams, 'sortOrder', 'desc');
            $books->orderBy($sortField, $direction);
        } else {
            $books->orderBy('id', 'desc');
        }

        return new JsonResponse($books->paginate());
    }

    /**
     * Gets a book
     *
     * @OA\Get(
     *     path="/api/books/{id}",
     *     tags={"books"},
     *
     *     @OA\Parameter(
     *          description="Id of the book",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="json"
     *     )
     * )
     */
    public function show(Request $request): JsonResponse
    {
        /** @var Book $book */
        $book = Book::findOrFail((int)$request->getAttribute('id'));

        return new JsonResponse($book);
    }

    /**
     * Creates a book
     *
     * @OA\Post(
     *     path="/api/books",
     *     tags={"books"},
     *
     *    @OA\RequestBody(
     *          required=true,
     *          description="Book's fields",
     *          @OA\JsonContent(
     *              required={"title", "author", "publication_year", "genre"},
     *              @OA\Property(property="title", type="string", example="Clean Code"),
     *              @OA\Property(property="author", type="string", example="Robert Cecil Martin"),
     *              @OA\Property(property="publication_year", type="integer", example=2008),
     *              @OA\Property(property="genre", type="string", example="Computers")
     *          ),
     *     ),
     *
     *     @OA\Response(
     *         response="201",
     *         description="json"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        /** @var Book $book */
        $book = Book::create(Arr::only($request->getParsedBody(), [
            'title',
            'author',
            'publication_year',
            'genre'
        ]));

        return new JsonResponse($book, StatusCodeInterface::STATUS_CREATED);
    }

    /**
     * Updates a book
     *
     * @OA\Put(
     *     path="/api/books/{id}",
     *     tags={"books"},
     *
     *     @OA\Parameter(
     *          description="Id of the book",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *          required=true,
     *          description="Book's fields",
     *          @OA\JsonContent(
     *              required={"title", "author", "publication_year", "genre"},
     *              @OA\Property(property="title", type="string", example="Clean Code"),
     *              @OA\Property(property="author", type="string", example="Robert Cecil Martin"),
     *              @OA\Property(property="publication_year", type="integer", example=2008),
     *              @OA\Property(property="genre", type="string", example="Computers")
     *          ),
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="json"
     *     )
     * )
     */
    public function update(Request $request): JsonResponse
    {
        /** @var Book $book */
        $book = Book::findOrFail((int)$request->getAttribute('id'));

        $book->update(Arr::only($request->getParsedBody(), [
            'title',
            'author',
            'publication_year',
            'genre'
        ]));

        return new JsonResponse($book);
    }

    /**
     * Deletes a book
     *
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     tags={"books"},
     *
     *     @OA\Parameter(
     *          description="Id of the book",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="json"
     *     )
     * )
     */
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
