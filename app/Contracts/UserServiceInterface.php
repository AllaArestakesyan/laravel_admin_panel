<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
   
    /**
     * Get all users.
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Get a user by its ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User;

    /**
     * Update an existing user avatar.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function uploadAvatar(int $id, mixed $data): ?User;

    /**
     * Delete a user by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
