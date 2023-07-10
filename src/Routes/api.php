<?php

use App\Http\Actions\HomeAction;
use App\Http\Controllers\BookController;
use Slim\App;
use Slim\Exception\HttpNotFoundException;

return function (App $app): void {
    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });

    $app->get('[/]', HomeAction::class);

    $app->get('/books', [BookController::class, 'index']);
    $app->get('/books/{id}', [BookController::class, 'show']);
    $app->post('/books', [BookController::class, 'store']);
    $app->put('/books/{id}', [BookController::class, 'update']);
    $app->delete('/books/{id}', [BookController::class, 'destroy']);

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     */
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request) {
        throw new HttpNotFoundException($request);
    });
};