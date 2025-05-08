<?php

namespace App\Contracts;

use App\Models\Admin;
use Illuminate\Support\Collection;

interface AdminServiceInterface
{

    /**
     * Summary of signUp
     * 
     * @param array $data
     * @return void
     */
    public function signUp(array $data): Admin;

    /**
     * Summary of signIn
     * 
     * @param array $data
     * @return void
     */
    public function signIn(array $data): ?array;


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
     * @return Admin|null
     */
    public function findById(int $id): ?Admin;

    /**
     * Update an existing admin.
     *
     * @param int $id
     * @param array $data
     * @return Admin|null
     */
    public function update(int $id, array $data): ?Admin;
  
  
    /**
     * Summary of update Password
     * 
     * @param int $id
     * @param array $data
     * @return void
     */
    public function updatePassword(int $id, array $data): ?Admin;
  
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
     * @return void
     */
    public function removeRole(int $id, string $role): array;

    
}
