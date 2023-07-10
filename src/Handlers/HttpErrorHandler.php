<?php

declare(strict_types=1);

namespace App\Handlers;

use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Slim\Error\Renderers\JsonErrorRenderer;
use Slim\Exception\HttpNotFoundException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Slim\Interfaces\ErrorRendererInterface;

class HttpErrorHandler extends SlimErrorHandler
{
    /**
     * @var string
     */
    protected string $defaultErrorRendererContentType = 'application/json';

    /**
     * @var ErrorRendererInterface|string|callable
     */
    protected $defaultErrorRenderer = JsonErrorRenderer::class;

    /**
     * @inheritdoc
     */
    protected function respond(): ResponseInterface
    {
        if ($this->exception instanceof ModelNotFoundException) {
            $this->exception = new HttpNotFoundException($this->request);
            $this->statusCode = StatusCodeInterface::STATUS_NOT_FOUND;
        }

        return parent::respond();
    }
}