<?php

use App\Services\AuthMiddleware;
use PHPUnit\Framework\TestCase;

class AuthMiddlewareTest extends TestCase
{
    // public function setUp(): void
    // {
    //     parent::setUp();
    //     session_start(); // Start the session before each test
    // }

    // public function tearDown(): void
    // {
    //     session_destroy(); // Destroy the session after each test
    //     parent::tearDown();
    // }

    public function testAuthenticateTokenUnauthorized()
    {
        AuthMiddleware::authenticateToken('levart', true, []);
        $this->assertJson(json_encode(['message' => 'Unauthorized']));
    }

    public function testAuthenticateTokenInvalidToken()
    {
        AuthMiddleware::authenticateToken('levart', true, ['Authorization' => 'invalid_token']);
        $this->assertJson(json_encode(['message' => 'Invalid token']));
    }

    public function testAuthenticateTokenValidToken()
    {
        $_SESSION['user'] = ['username' => 'test_user'];

        AuthMiddleware::authenticateToken('levart', true, ['Authorization' => 'valid_token']);

        $this->assertArrayHasKey('user', $_SESSION);
    }

    public function testAuthenticateTokenNoAuthRequired()
    {
        AuthMiddleware::authenticateToken('levart', false, []);

        $this->assertArrayNotHasKey('user', []);
    }
}