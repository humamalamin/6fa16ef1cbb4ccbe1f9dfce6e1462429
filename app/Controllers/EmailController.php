<?php

namespace App\Controllers;

use App\Model\EmailModel;
use App\Services\AuthMiddleware;
use Enqueue\Redis\RedisConnectionFactory;

class EmailController
{
    private $config;
    private $producer;
    private $emailModel;

    public function __construct(
        array $config,
        EmailModel $emailModel
    ) {
        AuthMiddleware::authenticateToken($config['app']['secret_key']);

        $this->config = $config;
        $configQueue = $config['queue']['redis'];
        $producer = [
            'host' => $configQueue['host'],
            'port' => $configQueue['port'],
        ];
        $redis = new RedisConnectionFactory($producer);
        $this->producer = $redis->createContext();
        $this->emailModel = $emailModel;
    }

    public function sendEmail($recipient, $subject, $message)
    {
        $fooQueue = $this->producer->createQueue('email_queue');
        $messageQueue = $this->producer->createMessage(json_encode([
            'recipient' => $recipient,
            'subject' => $subject,
            'message' => $message,
            'smtpConfig' => $this->config['smtp'],
            ]));

        $this->producer->createProducer()->send($fooQueue, $messageQueue);

        $this->emailModel->insert($recipient, $subject, $message);

        echo json_encode(["status" => 'success']);
    }
}
