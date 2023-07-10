<?php

use App\Handlers\HttpErrorHandler;
use App\Http\Middleware\EloquentPagination;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$configuration = require __DIR__ . '/../config/app.php';

$app = AppFactory::create();

$callableResolver = $app->getCallableResolver();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Connect Eloquent
$capsule = new CapsuleManager;
$capsule->addConnection($configuration['database']);

$capsule->bootEloquent();
$capsule->setAsGlobal();

$app->add(EloquentPagination::class);

return $app;
