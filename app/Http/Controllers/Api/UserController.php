<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateEmail(Request $request): JsonResponse
    {
        $data = $request->validate(['email' => 'required|email']);
        $user = Auth::user();
        $user->updateEmail($data['email']);
        return response()->json($user);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
        ]);

        $user = Auth::user();
        $user->updatePassword($data['currentPassword'], $data['newPassword']);
        return response()->json(['message' => 'Пароль обновлен']);
    }

    public function updatePhoto(Request $request): JsonResponse
    {
        $request->validate(['photo' => 'required|image']);
        $user = Auth::user();
        // Логика сохранения файла и получение пути
        $photoPath = 'path/to/saved/photo.jpg';
        $user->updateProfilePhoto($photoPath);
        return response()->json(['message' => 'Фото обновлено']);
    }

    public function updatePhotos(Request $request): JsonResponse
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image',
        ]);

        $user = Auth::user();
        // Логика сохранения файлов и получение путей
        $photosPaths = ['path1.jpg', 'path2.jpg'];
        $user->updatePhotos($photosPaths);
        return response()->json(['message' => 'Коллекция фото обновлена']);
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

        Auth::user()->updateProfile($validated);
        return response()->json(Auth::user()->toOpenApiModel());
    }

    public function destroy(): JsonResponse
    {
        Auth::user()->delete();
        return response()->json(null, 204);
    }
}
