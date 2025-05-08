<?php

namespace App\Services;

use App\Contracts\AdminServiceInterface;
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
     * @return Admin
     */
    public function signUp(array $data): Admin
    {
        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $admin->assignRole($data['role']);
        // Auth::guard('web')->login($admin);

        return $admin;
    }

    /**
     * Summary of signIn
     * 
     * @param array $data
     * @return array|null
     */
    public function signIn(array $data): ?array
    {

        $admin = Admin::where('email', $data["email"])->first();

        if (!$admin || !Hash::check($data["password"], $admin->password)) {

            return null;
        }

        if (Auth::guard('web')->attempt(['email' =>$data['email'], 'password' =>$data['password']])) {
            return $data;
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
        return Admin::all(); 
    }

    /**
     * Get a Admin by its ID.
     *
     * @param int $id
     * @return Admin|null
     */
    public function findById(int $id): ?Admin
    {
        return Admin::find($id);
    }

    /**
     * Update an existing Admin.
     *
     * @param int $id
     * @param array $data
     * @return Admin|null
     */
    public function update(int $id, array $data): ?Admin
    {
        $admin = Admin::find($id); 
        if ($admin) {
            $admin->update($data); 
            return $admin;
        }
        return null;
    }


    /**
     * Update an existing Admin avatar.
     *
     * @param int $id
     * @param array $data
     * @return Admin|null
     */


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

}