<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use OpenAPI\Server\Model\User as OpenApiUser;
use Throwable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'age', 'height', 'children',
        'photo', 'photos', 'birthdate', 'chatId', 'hasChat',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'date',
        'photos' => 'array',
        'hasChat' => 'boolean',
    ];

    /**
     * Обновление email пользователя
     * @throws Throwable
     */
    public function updateEmail(string $email): void
    {
        $this->email = $email;
        $this->saveOrFail();
    }

    /**
     * Обновление пароля с проверкой текущего
     * @throws Throwable
     */
    public function updatePassword(string $currentPassword, string $newPassword): void
    {
        if (!Hash::check($currentPassword, $this->password)) {
            throw new \RuntimeException('Неверный текущий пароль');
        }

        $this->password = Hash::make($newPassword);
        $this->saveOrFail();
    }

    /**
     * Обновление основной фотографии
     * @throws Throwable
     */
    public function updateProfilePhoto(string $photoPath): void
    {
        $this->photo = $photoPath;
        $this->saveOrFail();
    }

    /**
     * Обновление коллекции фотографий
     * @throws Throwable
     */
    public function updatePhotos(array $photos): void
    {
        $this->photos = $photos;
        $this->saveOrFail();
    }

    /**
     * Преобразование в OpenAPI-модель
     */
    public function toOpenApiModel(): OpenApiUser
    {
        return new OpenApiUser(
            name: $this->name,
            age: $this->age,
            height: $this->height,
            children: $this->children,
            photo: $this->photo,
            photos: $this->photos ?? [],
            birthdate: $this->birthdate,
            chatId: $this->chatId,
            hasChat: $this->hasChat,
        );
    }

    /**
     * Обновление профиля с валидацией
     * @throws Throwable
     */
    public function updateProfile(array $attributes): void
    {
        $this->fill($attributes)->saveOrFail();
    }
}
