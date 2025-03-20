<?php

namespace App\Services;

use App\Models\User;
use App\DTO\UserDTO;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserService
{
    /**
     * @throws Throwable
     */
    public function updateProfile(User $user, UserDTO $userDTO): User
    {
        $user->fill($userDTO->toArray());
        $user->saveOrFail();
        return $user;
    }

    /**
     * @throws Throwable
     */
    public function updateEmail(User $user, string $email): User
    {
        $user->email = $email;
        $user->saveOrFail();
        return $user;
    }

    /**
     * @throws Throwable
     */
    public function updatePassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new \InvalidArgumentException('Неверный текущий пароль');
        }
        $user->password = Hash::make($newPassword);
        $user->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function updateProfilePhoto(User $user, string $photoPath): User
    {
        $user->photo = $photoPath;
        $user->saveOrFail();
        return $user;
    }

    /**
     * @throws Throwable
     */
    public function updatePhotos(User $user, array $photos): User
    {
        $user->photos = $photos;
        $user->saveOrFail();
        return $user;
    }

    /**
     * @throws Throwable
     */
    public function deleteUser(User $user): void
    {
        $user->delete();
    }
}
