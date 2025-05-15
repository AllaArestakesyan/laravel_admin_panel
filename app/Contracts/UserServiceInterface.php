<?php

namespace App\Contracts;

use App\Data\UpdateUserData;
use App\Data\UpdateUserPasswordData;
use App\Data\UserData;
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
     * @return UserData|null
     */
    public function findById(int $id): ?UserData;

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param UpdateUserData $data
     * @return UserData|null
     */
    public function update(int $id, UpdateUserData $data): ?UserData;

    /**
     * Summary of update Password
     * 
     * @param int $id
     * @param UpdateUserPasswordData $data
     * @return UserData
     */
    public function updatePassword(int $id, UpdateUserPasswordData $data): ?UserData;


    /**
     * Update an existing user avatar.
     *
     * @param int $id
     * @param array $data
     * @return UserData|null
     */
    public function uploadAvatar(int $id, mixed $data): ?UserData;

    /**
     * Delete a user by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
