<?php

namespace App\Model;

use PDO;

class EmailModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function insert($recipient, $subject, $message)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO recipients (email, subjects, message) VALUES (:email,:subject,:message)'
        );
        $stmt->bindParam(':email', $recipient);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    }
}
