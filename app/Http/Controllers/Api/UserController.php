<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Получить профиль текущего пользователя.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        return response()->json($user->toOpenApiModel());
    }

    /**
     * Обновить профиль текущего пользователя.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $validatedData = $request->validate([
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

        $user->update($validatedData);

        return response()->json($user->toOpenApiModel());
    }

    /**
     * Удалить текущего пользователя.
     *
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $user->delete();

        return response()->json(null, 204);
    }
}
