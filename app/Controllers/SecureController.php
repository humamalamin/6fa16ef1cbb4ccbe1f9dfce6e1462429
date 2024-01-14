<?php

namespace App\Controllers;

use Firebase\JWT\JWT;

class SecureController
{
    protected $configApp;

    public function __construct($configApp)
    {
        $this->configApp = $configApp;
    }

    public function generateToken()
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;

        $payload = [
            'username' => $this->configApp['user_test'],
            'iat' => $issuedAt,
            'exp' => $expirationTime,
        ];

        $token = JWT::encode(
            $payload,
            $this->configApp['secret_key'],
            'HS256'
        );

        echo json_encode(['token' => $token]);
    }
}
