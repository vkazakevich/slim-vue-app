<?php

namespace App\Http\Middleware;

use Illuminate\Support\Arr;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Illuminate\Pagination\Paginator;

class EloquentPagination
{
    /**
     * Example middleware invokable class
     *
     * @param  Request  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        Paginator::currentPageResolver(function () use ($request) {
            return (int) Arr::get($request->getQueryParams(), 'page');
        });

        return $handler->handle($request);;
    }
}