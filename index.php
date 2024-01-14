<?php

require_once 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();

use App\Controllers\EmailController;
use App\Controllers\SecureController;
use App\Model\EmailModel;

$config = require 'config/config.php';
$request_uri = $_SERVER['REQUEST_URI'];

try {
    $pdo = new \PDO(
        "pgsql:host={$config['database']['host']};port={$config['database']['port']};
        dbname={$config['database']['name']}",
        $config['database']['username'],
        $config['database']['password']
    );

    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
} 

switch ($request_uri) {
    case '/send-email':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validation = validation($_POST);
            if (!empty($validation)) {
                echo json_encode([
                    'message' => $validation
                ]);

                return;
            }
            $recipient = $_POST['recipient'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
        }
        
        $emailModel = new EmailModel($pdo);
        $emailController = new EmailController($config, $emailModel);
        
        $emailController->sendEmail($recipient, $subject, $message);
    
        break;
    case '/generate-token':
        $secureController = new SecureController($config['app']);
        $secureController->generateToken();

        break;
    default:
        echo json_encode(['message' => 'Public resource']);
        break;
}

function validation($field)
{
    if (empty($field['recipient'])) {
        http_response_code(422);
        return  'recipient is_required';
    }

    if (empty($field['subject'])) {
        http_response_code(422);
        return 'subject is_required';
    }

    if (empty($field['message'])) {
        http_response_code(422);
        return 'message is_required';
    }

    if (!filter_var($field['recipient'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        return "Invalid format e-mail";
    }

    return null;
}