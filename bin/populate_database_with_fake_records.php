<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap/app.php';

use App\Models\Book;
use App\Models\Enums\BookGenreEnum;
use Illuminate\Support\Facades\Date;

echo 'GENERATE FAKE BOOKS START' . PHP_EOL;

$faker = Faker\Factory::create();
$now = Date::now();

$books = [];
for ($i = 0; $i < 100; $i++) {
    $sentence = $faker->sentence(5);

    $books[] = [
        'title' => substr($sentence, 0, strlen($sentence) - 1),
        'author' => $faker->name,
        'publication_year' => (int)$faker->year,
        'genre' => BookGenreEnum::randomValue(),

        'created_at' => $now,
        'updated_at' => $now
    ];
}

Book::insert($books);

echo 'GENERATE FAKE BOOKS COMPLETED' . PHP_EOL;