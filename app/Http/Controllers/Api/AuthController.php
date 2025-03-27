<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\DTO\UserRegistrationDTO;
use App\DTO\UserLoginDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * Регистрация пользователя.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $dto = new UserRegistrationDTO(
                email: $request->email,
                password: $request->password
            );

            $response = $this->authService->register($dto);

            return response()->json($response, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка создания пользователя',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Авторизация пользователя.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $dto = new UserLoginDTO(
                email: $request->email,
                password: $request->password
            );

            $response = $this->authService->login($dto);

            return response()->json($response);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Неверные учетные данные',
                'errors' => $e->errors(),
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Произошла ошибка при входе',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
