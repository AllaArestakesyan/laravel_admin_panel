<?php

namespace App\Contracts;

use App\Models\User;


interface AuthServiceInterface
{
    
    /**
     * Summary of signUp
     * 
     * @param array $data
     * @return void
     */
    public function signUp(array $data): User;
    
    /**
     * Summary of signIn
     * 
     * @param array $data
     * @return void
     */
    public function signIn(array $data): ?array;

}
