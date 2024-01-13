<?php

namespace App\Controllers;

use App\Services\EmailService;
use Enqueue\Redis\RedisConnectionFactory;

class EmailConsumerController
{
    private $producer;
    private $emailService;

    public function __construct($configQueue, EmailService $emailService)
    {
        $producer = [
            'host' => $configQueue['host'],
            'port' => $configQueue['port'],
        ];
        $redis = new RedisConnectionFactory($producer);
        $this->producer = $redis->createContext();
        $this->emailService = $emailService;
    }

    public function processQueue()
    {
        while (true) {
            $fooQueue = $this->producer->createQueue('email_queue');
            $consumer = $this->producer->createConsumer($fooQueue);

            $message = $consumer->receive();

            if (!$message) {
                usleep(1000000);
                continue;
            }

            $emailData = json_decode($message->getBody(), true);
            $result = $this->emailService->sendEmail(
                $emailData['recipient'],
                $emailData['subject'],
                $emailData['message'],
                $emailData['smtpConfig']
            );
            echo "Sending email to {$emailData['recipient']} with subject '{$emailData['subject']}'\n";

            $consumer->acknowledge($message);
        }
    }
}
