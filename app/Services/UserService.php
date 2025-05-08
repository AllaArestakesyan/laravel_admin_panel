<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class UserService implements UserServiceInterface
{
    
    /**
     * Get all users.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return User::all(); 
    }

    /**
     * Get a user by its ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function update(int $id, array $data): ?User
    {
        $user = User::find($id); 
        if ($user) {
            $user->update($data); 
            return $user;
        }
        return null;
    }


    /**
     * Update an existing user avatar.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */

    public function uploadAvatar(int $id, array $data):?User
    {

        $user = User::find($id);

        if (!$user) {
            return null;
        }

        if (!$data->avatar) {
            return null;
        }

        $file = $data->file('avatar');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $fileName, 'public');
        $user->avatar = str_replace('public/', '', $path);
        $user->save();

        return $user;
    }

    /**
     * Delete a user by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return User::destroy($id) > 0; 
    }
}