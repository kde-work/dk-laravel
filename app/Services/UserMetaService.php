<?php

namespace App\Services;

use App\DTO\UserMetaDTO;
use App\Models\Usermeta;
use App\Domain\User\ValueObjects\UserMetaKey;

class UserMetaService
{
    public function setMeta(UserMetaDTO $dto): Usermeta
    {
        return Usermeta::updateOrCreate(
            [
                'user_id' => $dto->userId,
                'key' => $dto->key->value,
            ],
            [
                'value' => $dto->value
            ]
        );
    }

    public function getMeta(int $userId, UserMetaKey $key): mixed
    {
        return Usermeta::where('user_id', $userId)
            ->forKey($key)
            ->value('value');
    }
}
