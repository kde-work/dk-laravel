<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);
        return $user && $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        return $user ? $user->delete() : false;
    }
}
