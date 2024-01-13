<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PDO;

class EmailService
{
    public function sendEmail($recipient, $subject, $message, $config)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $config['username'];
            $mail->Password   = $config['password'];
            $mail->SMTPSecure = $config['encryption'];
            $mail->Port       = $config['port'];

            $mail->setFrom($config['from'], $config['name']);
            $mail->addAddress($recipient, $recipient);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();

            return true;
        } catch (Exception $th) {
            error_log($th->getMessage());
            return false;
        }
    }
}
