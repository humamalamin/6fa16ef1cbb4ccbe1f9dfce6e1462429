<?php

require_once __DIR__.'/vendor/autoload.php';
use App\Controllers\EmailConsumerController;
use App\Services\EmailService;

$config = require 'config/config.php';

try {
    $pdo = new PDO(
        "pgsql:host=" . $config['database']['host'] .
        ";dbname="  . $config['database']['name'] . "," .
        $config['database']['username'],
        $config['database']['password']
    );

    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
} 

$emailService = new EmailService($pdo);
$consumer = new EmailConsumerController($config['queue']['redis'], $emailService);
$consumer->processQueue();
