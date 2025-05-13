<?php

namespace App\Services;

use App\Contracts\AdminServiceInterface;
use App\Data\AdminData;
use App\Data\ResponseData;
use App\Data\SignInUserData;
use App\Data\StoreAdminData;
use App\Data\UpdateAdminData;
use App\Data\UpdateUserPasswordData;
use App\Models\Admin;
use Hash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AdminService implements AdminServiceInterface
{
    /**
     * Summary of signUp
     * 
     * @param array $data
     * @return AdminData
     */
    public function signUp(StoreAdminData $data): AdminData
    {
        $admin = Admin::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        $admin->assignRole($data['role']);
        // Auth::guard('web')->login($admin);

        return AdminData::from($admin);
    }

    /**
     * Summary of signIn
     * 
     * @param SignInUserData $data
     * @return array|null
     */
    public function signIn(SignInUserData $data): ?array
    {

        $admin = Admin::where('email', $data->email)->first();

        if (!$admin || !Hash::check($data->password, $admin->password)) {

            return null;
        }

        if (Auth::guard('web')->attempt(['email' => $data->email, 'password' => $data->password])) {
            return $data->toArray();
        }

        return null;
    }

    /**
     * Get all Admins.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        $admins = Admin::with('roles')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin');
            })
            ->get();

        return AdminData::collect($admins);
    }

    /**
     * Get a Admin by its ID.
     *
     * @param int $id
     * @return AdminData|null
     */
    public function findById(int $id): ?AdminData
    {
        $admin = Admin::findOrFail($id);

        return AdminData::from($admin);
    }

    /**
     * Update an existing Admin.
     *
     * @param int $id
     * @param UpdateAdminData $data
     * @return AdminData|null
     */
    public function update(int $id, UpdateAdminData $data): ?AdminData
    {
        $admin = Admin::find($id);
        
        if ($admin) {

            $admin->update([
                'name' => $data->name,
            ]);

            if (isset($data->role)) {

                $admin->assignRole($data->role);

            }

            return AdminData::from($admin);
        }
        return null;
    }

    /**
     * Summary of update Password
     * 
     * @param int $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder<Admin>|null
     */
    public function updatePassword(int $id, UpdateUserPasswordData $data): ?AdminData
    {
        $admin = Admin::find($id);

        if (!$admin || !Hash::check($data->old_password, $admin->password)) {

            return null;
        }
        $admin->password = Hash::make($data->password);
        $admin->save();

        return AdminData::from($admin);
    }

    /**
     * Delete a admin by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Admin::destroy($id) > 0;
    }


    public function removeRole(int $id, string $role): ResponseData
    {
        $admin = Admin::findOrFail($id);

        if (!$admin) {

            return ResponseData::from(
                ["error" => true, "message" => 'Admin not found.']
            );
        }

        if ($admin->hasRole('super-admin')) {

            return ResponseData::from(
                ["error" => true, "message" => 'You cannot remove role from a super-admin.']
            );
        }

        if ($admin->hasRole($role)) {
            $admin->removeRole($role);

            return ResponseData::from(
                ["error" => false, "message" => "Role '{$role}' removed."]
            );
        }

        return ResponseData::from(
            ["error" => true, "message" => 'Admin does not have that role.']
        );
    }
}