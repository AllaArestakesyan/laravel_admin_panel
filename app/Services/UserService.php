<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Data\UpdateUserData;
use App\Data\UpdateUserPasswordData;
use App\Data\UserData;
use App\Mail\SendEmail;
use App\Models\User;
use Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class UserService implements UserServiceInterface
{

    /**
     * Get all users.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return UserData::collect(User::all());
    }

    /**
     * Get a user by its ID.
     *
     * @param int $id
     * @return UserData|null
     */
    public function findById(int $id): ?UserData
    {
        $user = User::findOrFail($id);

        return UserData::from($user);
    }

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param UpdateUserData $data
     * @return UserData|null
     */
    public function update(int $id, UpdateUserData $data): ?UserData
    {
        $user = User::find($id);
        if ($user) {
            $user->update([
                "name" => $data->name,
            ]);

            return UserData::from($user);
        }
        return null;
    }

    /**
     * Summary of updatePassword
     * 
     * @param int $id
     * @param array $data
     */
    public function updatePassword(int $id, UpdateUserPasswordData $data): ?UserData
    {
        $user = User::find($id);

        if (!$user || !Hash::check($data->old_password, $user->password)) {

            return null;
        }
        $user->password = Hash::make($data->password);
        $user->save();

        return UserData::from($user);
    }


    /**
     * Update an existing user avatar.
     *
     * @param int $id
     * @param array $data
     * @return UserData|null
     */

    public function uploadAvatar(int $id, mixed $file): ?UserData
    {

        $user = User::find($id);

        if (!$user) {
            return null;
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $fileName, 'public');
        $user->avatar = str_replace('public/', '', $path);
        $user->save();

        return UserData::from($user);
    }

    /**
     * Delete a user by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $user = User::find($id);
        if($user){
            Mail::to('alla.arestakesyan@gmail.com')
            ->send(new SendEmail($user->name, "Your account has been deleted.", "Delete Account"));

        }
        return User::destroy($id) > 0;
    }
}