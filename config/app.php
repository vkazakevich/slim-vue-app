<?php

return [
    'database' => [
        'driver' => 'mysql',
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'database' => $_ENV['DB_DATABASE'] ?? 'book_ms',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
        'port' => $_ENV['DB_PORT'] ?? 3306,
        'collation' => 'utf8_general_ci',
        'charset' => 'utf8',
        'prefix' => ''
    ],
];
