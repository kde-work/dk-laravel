<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\DTO\UserDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function show(): JsonResponse
    {
        return response()->json(Auth::user()->toOpenApiModel());
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'age' => 'integer|min:0',
            'height' => 'numeric|min:0',
            'children' => 'boolean',
            'photo' => 'string|url',
            'photos' => 'array',
            'birthdate' => 'date',
            'chatId' => 'string|max:255',
            'hasChat' => 'boolean',
        ]);

        try {
            $userDTO = UserDTO::fromArray($validated);
            $updatedUser = $this->userService->updateProfile(Auth::user(), $userDTO);

            return response()->json($updatedUser->toOpenApiModel());
        } catch (\Exception|\Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить профиль'], 500);
        }
    }

    public function updateEmail(Request $request): JsonResponse
    {
        $data = $request->validate(['email' => 'required|email']);

        try {
            $user = $this->userService->updateEmail(Auth::user(), $data['email']);
            return response()->json($user->toOpenApiModel());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось обновить email'], 500);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
        ]);

        try {
            $this->userService->updatePassword(Auth::user(), $data['currentPassword'], $data['newPassword']);
            return response()->json(['message' => 'Пароль обновлен']);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception|\Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить пароль'], 500);
        }
    }

    public function updatePhoto(Request $request): JsonResponse
    {
        $request->validate(['photo' => 'required|image']);

        try {
            $photoPath = 'path/to/saved/photo.jpg'; // Логика сохранения файла
            $user = $this->userService->updateProfilePhoto(Auth::user(), $photoPath);
            return response()->json(['message' => 'Фото обновлено', 'user' => $user->toOpenApiModel()]);
        } catch (\Exception|\Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить фото'], 500);
        }
    }

    public function updatePhotos(Request $request): JsonResponse
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image',
        ]);

        try {
            $photosPaths = ['path1.jpg', 'path2.jpg']; // Логика сохранения файлов
            $user = $this->userService->updatePhotos(Auth::user(), $photosPaths);
            return response()->json(['message' => 'Коллекция фото обновлена', 'user' => $user->toOpenApiModel()]);
        } catch (\Exception|\Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить коллекцию фото'], 500);
        }
    }

    public function destroy(): JsonResponse
    {
        try {
            $this->userService->deleteUser(Auth::user());
            return response()->json(null, 204);
        } catch (\Exception|\Throwable $e) {
            return response()->json(['error' => 'Не удалось удалить пользователя'], 500);
        }
    }
}
