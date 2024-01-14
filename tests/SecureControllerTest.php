<?php

use App\Controllers\SecureController;
use PHPUnit\Framework\TestCase;

class SecureControllerTest extends TestCase
{
    public function testGenerateToken()
    {
        $fakeConfig = [
            'user_test' => 'test_user',
            'secret_key' => 'test_secret_key',
        ];

        $tokenGenerator = new SecureController($fakeConfig);

        $generatedToken = $tokenGenerator->generateToken();

        $this->assertNotEmpty($generatedToken);
    }

    public function testGenerateTokenAsJson()
    {
        $fakeConfig = [
            'user_test' => 'test_user',
            'secret_key' => 'test_secret_key',
        ];

        $tokenGenerator = new SecureController($fakeConfig);

        $generatedToken = $tokenGenerator->generateTokenAsJson();

        $this->assertJson($generatedToken);
    }
}