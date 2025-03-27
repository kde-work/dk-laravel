<?php

namespace Tests\Integration\Controllers;

use App\Http\Controllers\Api\AuthController;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthControllerIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест взаимодействия контроллера с сервисом при регистрации.
     */
    public function testRegisterCallsAuthService(): void
    {
        $authServiceMock = $this->createMock(AuthService::class);
        $authServiceMock->method('register')->willReturn([
            'access_token' => 'mock_token',
            'token_type' => 'Bearer',
        ]);

        $controller = new AuthController($authServiceMock);

        $request = Request::create('/api/v2/auth/register', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password123_!',
        ]);

        $response = $controller->register($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertArrayHasKey('access_token', json_decode($response->getContent(), true));
    }
}
