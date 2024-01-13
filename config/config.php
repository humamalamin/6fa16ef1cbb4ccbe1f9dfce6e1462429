<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

return [
    'app' => [
        "name" => $_ENV['APP_NAME'],
        "timezone" => $_ENV['APP_TIMEZONE'],
        'secret_key' => $_ENV['SECRET_KEY'],
        'user_test' => $_ENV['APP_USER_TEST'],
    ],
    'smtp' => [
        'host' => $_ENV['MAIL_HOST'],
        'mailer' => $_ENV['MAIL_MAILER'],
        'port' => $_ENV['MAIL_PORT'],
        'username' => $_ENV['MAIL_USERNAME'],
        'password' => $_ENV['MAIL_PASSWORD'],
        'encryption' => $_ENV['MAIL_ENCRYPTION'],
        'from' => $_ENV['MAIL_FROM_ADDRESS'],
        'name' => $_ENV['MAIL_FROM_NAME']
    ],
    'database' => [
       'host' => $_ENV['DB_HOST'],
       'port' => $_ENV['DB_PORT'],
       'username' => $_ENV['DB_USERNAME'],
       'password' => $_ENV['DB_PASSWORD'],
       'name' => $_ENV['DB_NAME'],
    ],
    'queue' => [
        'default' => 'redis',
        'redis' => [
            'host' => $_ENV['QUEUE_HOST'],
            'password' => $_ENV['QUEUE_PASSWORD'],
            'port' => $_ENV['QUEUE_PORT']
        ],
    ]
];