<?php

namespace Tests\Unit\Services;

use App\Services\AuthService;
use App\DTO\UserRegistrationDTO;
use App\DTO\UserLoginDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешной регистрации через сервис.
     */
    public function testRegisterCreatesUserAndReturnsToken(): void
    {
        $dto = new UserRegistrationDTO(
            email: 'test@example.com',
            password: 'password123'
        );

        $service = new AuthService();

        $result = $service->register($dto);

        $this->assertArrayHasKey('access_token', $result);
        $this->assertArrayHasKey('token_type', $result);
        $this->assertEquals('Bearer', $result['token_type']);
        $this->assertStringContainsString('|', $result['access_token']);
    }

    /**
     * Тест ошибки авторизации с неверными данными.
     */
    public function testLoginThrowsValidationExceptionForInvalidCredentials(): void
    {
        $dto = new UserLoginDTO(
            email: 'invalid@example.com',
            password: 'wrongpassword'
        );

        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => $dto->email, 'password' => $dto->password])
            ->andReturn(false);

        $service = new AuthService();

        $this->expectException(ValidationException::class);

        $service->login($dto);
    }
}
