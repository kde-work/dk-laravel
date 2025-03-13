<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use OpenAPI\Server\Model\User as OpenApiUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'height',
        'children',
        'photo',
        'photos',
        'birthdate',
        'chatId',
        'hasChat',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'date',
        'photos' => 'array',
        'hasChat' => 'boolean',
    ];

    /**
     * @throws Exception
     */
    public static function create(array $attributes = []) {
        try {
            return static::query()->create($attributes);
        } catch (\Illuminate\Database\QueryException $e) {
            var_export($e->getMessage());
            throw new Exception('Ошибка при создании пользователя: ' . $e->getMessage());
        }
    }

    public static function where($column, $operator = null, $value = null, $boolean = 'and'): Builder
    {
        return static::query()->where($column, $operator, $value, $boolean);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Преобразовать текущую модель в OpenAPI-модель.
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
