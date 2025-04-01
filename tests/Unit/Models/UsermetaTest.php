<?php

namespace Tests\Unit\Models;

use App\Models\Usermeta;
use App\Models\User;
use App\Domain\User\ValueObjects\UserMetaKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsermetaTest extends TestCase
{
    use RefreshDatabase;

    public function testUsermetaCanBeCreated(): void
    {
        $user = User::factory()->create();

        $usermeta = Usermeta::create([
            'user_id' => $user->id,
            'key' => UserMetaKey::AVATAR,
            'value' => 'avatar.jpg',
        ]);

        $this->assertDatabaseHas('usermeta', [
            'id' => $usermeta->id,
            'user_id' => $user->id,
            'key' => UserMetaKey::AVATAR,
            'value' => json_encode('avatar.jpg'),
        ]);
    }

    public function testValueIsSerializedAndDeserializedCorrectly(): void
    {
        $user = User::factory()->create();

        $usermeta = Usermeta::create([
            'user_id' => $user->id,
            'key' => UserMetaKey::GALLERY,
            'value' => ['img1.jpg', 'img2.jpg'],
        ]);

        // Проверяем, что в базе данных хранится JSON
        $this->assertDatabaseHas('usermeta', [
            'id' => $usermeta->id,
            'key' => UserMetaKey::GALLERY,
            'value' => json_encode(['img1.jpg', 'img2.jpg']),
        ]);

        // Проверяем, что при доступе к атрибуту value возвращается массив
        $this->assertEquals(['img1.jpg', 'img2.jpg'], $usermeta->value);
    }

    public function testScopeForKeyWorksCorrectly(): void
    {
        $user = User::factory()->create();

        Usermeta::where('user_id', $user->id)
            ->whereIn('key', [UserMetaKey::AVATAR->value, UserMetaKey::GALLERY->value])
            ->delete();

        Usermeta::create([
            'user_id' => $user->id,
            'key' => UserMetaKey::AVATAR,
            'value' => 'avatar.jpg',
        ]);

        Usermeta::create([
            'user_id' => $user->id,
            'key' => UserMetaKey::GALLERY,
            'value' => ['img1.jpg', 'img2.jpg'],
        ]);

        // Используем скауп forKey для фильтрации по ключу
        $avatarMeta = Usermeta::query()->forKey(UserMetaKey::AVATAR)->first();

        // Проверяем, что скауп возвращает правильную запись
        $this->assertNotNull($avatarMeta);
        $this->assertEquals('avatar', $avatarMeta->key);
        $this->assertEquals('avatar.jpg', $avatarMeta->value);
    }

    public function testUsermetaCanStoreSimpleValues(): void
    {
        $user = User::factory()->create();

        // Сохраняем простое строковое значение
        $usermeta = Usermeta::create([
            'user_id' => $user->id,
            'key' => 'status',
            'value' => 'active',
        ]);

        // Проверяем, что значение сохраняется корректно
        $this->assertEquals('active', $usermeta->value);
    }
}
