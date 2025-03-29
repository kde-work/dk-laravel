<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Domain\User\ValueObjects\UserMetaKey;

class Usermeta extends Model
{
    protected $table = 'usermeta';

    protected $fillable = ['user_id', 'key', 'value'];

    public function getValueAttribute($value): mixed
    {
        return json_decode($value, true) ?? $value;
    }

    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = is_array($value)
            ? json_encode($value)
            : $value;
    }

    public function scopeForKey(Builder $query, UserMetaKey $key): void
    {
        $query->where('key', $key->value);
    }
}
