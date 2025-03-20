<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenAPI\Server\Model\User as OpenApiUser;

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
}
