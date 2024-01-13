<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    public static function authenticateToken($key, $requireAuth = true)
    {
        $token = isset(getallheaders()['Authorization']) ? getallheaders()['Authorization'] : null;

        if (!$token) {
            if ($requireAuth) {
                http_response_code(401);
                exit(json_encode(['message' => 'Unauthorized']));
            } else {
                return;
            }
        }

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $_SESSION['user'] = $decoded;
        } catch (\Exception $e) {
            if ($requireAuth) {
                http_response_code(403);
                exit(json_encode(['message' => 'Invalid token']));
            } else {
                return;
            }
        }
    }
}
