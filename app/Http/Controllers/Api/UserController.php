<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\PhotoService;
use App\DTO\UserDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService  $userService,
        private readonly PhotoService $photoService
    )
    {
    }

    public function show(): JsonResponse
    {
        /** @var UserDTO $userDTO */
        $userDTO = Auth::user()->toDTO();
        return response()->json($userDTO->toOpenApiModel());
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

            return response()->json($updatedUser->toDTO()->toOpenApiModel());
        } catch (Exception|Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить профиль. ' . $e->getMessage()], 500);
        }
    }

    public function updateEmail(Request $request): JsonResponse
    {
        $data = $request->validate(['email' => 'required|email']);

        try {
            $user = $this->userService->updateEmail(Auth::user(), $data['email']);
            return response()->json($user->toDTO()->toOpenApiModel());
        } catch (Exception|Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить email. ' . $e->getMessage()], 500);
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
        } catch (InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Exception|Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить пароль. ' . $e->getMessage()], 500);
        }
    }

    public function updatePhoto(Request $request): JsonResponse
    {
        $request->validate(['photo' => 'required|image']);

        try {
            $photoPath = $this->photoService->upload($request->file('photo'));
            $user = $this->userService->updateProfilePhoto(Auth::user(), $photoPath);
            return response()->json(['message' => 'Фото обновлено', 'user' => $user->toDTO()->toOpenApiModel()]);
        } catch (Exception|Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить фото. ' . $e->getMessage()], 500);
        }
    }

    public function updatePhotos(Request $request): JsonResponse
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image',
        ]);

        try {
            $photosPaths = $this->photoService->upload($request->file('photos'));
            $user = $this->userService->updatePhotos(Auth::user(), $photosPaths);
            return response()->json(['message' => 'Коллекция фото обновлена', 'user' => $user->toDTO()->toOpenApiModel()]);
        } catch (Exception|Throwable $e) {
            return response()->json(['error' => 'Не удалось обновить коллекцию фото. ' . $e->getMessage()], 500);
        }
    }

    public function destroy(): JsonResponse
    {
        try {
            $this->userService->deleteUser(Auth::user());
            return response()->json(null, 204);
        } catch (Exception|Throwable $e) {
            return response()->json(['error' => 'Не удалось удалить пользователя. ' . $e->getMessage()], 500);
        }
    }
}
