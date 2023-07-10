<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/app.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

echo 'DATABASE CREATE START' . PHP_EOL;

Capsule::schema()->dropIfExists('books');
Capsule::schema()->create('books', function (Blueprint $table) {
    $table->id();

    $table->string('title');
    $table->string('author');
    $table->year('publication_year');
    $table->string('genre');

    $table->timestamps();
    $table->softDeletes();
});

echo 'DATABASE CREATE COMPLETED' . PHP_EOL;