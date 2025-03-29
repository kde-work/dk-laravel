<?php

namespace App\Models;

use App\DTO\UserDTO;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $age
 * @property float $height
 * @property bool $children
 * @property string $photo
 * @property array $photos
 * @property DateTime $birthdate
 * @property string|null $chatId
 * @property bool $hasChat
 */
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

    public function toDTO(): UserDTO
    {
        return UserDTO::fromUser($this);
    }

    public function meta(): HasMany
    {
        return $this->hasMany(Usermeta::class);
    }

    public function getMeta(string $key): ?string
    {
        return $this->meta()->where('key', $key)->value('value');
    }

    public function setMeta(string $key, string $value): void
    {
        $this->meta()->updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
