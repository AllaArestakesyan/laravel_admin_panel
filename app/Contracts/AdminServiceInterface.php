<?php

namespace App\Contracts;

use App\Data\AdminData;
use App\Data\ResponseData;
use App\Data\SignInUserData;
use App\Data\StoreAdminData;
use App\Data\UpdateAdminData;
use App\Data\UpdateUserPasswordData;
use App\Models\Admin;
use Illuminate\Support\Collection;

interface AdminServiceInterface
{

    /**
     * Summary of signUp
     * 
     * @param StoreAdminData $data
     * @return AdminData
     */
    public function signUp(StoreAdminData $data): AdminData;

    /**
     * Summary of signIn
     * 
     * @param SignInUserData $data
     * @return array
     */
    public function signIn(SignInUserData $data): ?array;


    /**
     * Get all admins.
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Get a Admin by its ID.
     *
     * @param int $id
     * @return AdminData|null
     */
    public function findById(int $id): ?AdminData;

    /**
     * Update an existing admin.
     *
     * @param int $id
     * @param UpdateAdminData $data
     * @return AdminData|null
     */
    public function update(int $id, UpdateAdminData $data): ?AdminData;
  
  
    /**
     * Summary of update Password
     * 
     * @param int $id
     * @param UpdateUserPasswordData $data
     * @return AdminData
     */
    public function updatePassword(int $id, UpdateUserPasswordData $data): ?AdminData;
  
    /**
     * Delete a admin by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
   
    /**
     * Summary of removeRole
     * 
     * @param int $id
     * @return ResponseData
     */
    public function removeRole(int $id, string $role): ResponseData;

}