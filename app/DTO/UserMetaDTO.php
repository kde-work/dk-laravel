<?php

namespace App\DTO;

use App\Domain\User\ValueObjects\UserMetaKey;

class UserMetaDTO
{
    public function __construct(
        public readonly int         $userId,
        public readonly UserMetaKey $key,
        public readonly mixed       $value
    )
    {
    }
}
