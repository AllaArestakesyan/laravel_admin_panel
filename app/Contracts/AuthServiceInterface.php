<?php

namespace App\Contracts;

use App\Data\SignInUserData;
use App\Data\StoreUserData;
use App\Data\UserData;


interface AuthServiceInterface
{
    
    /**
     * Summary of signUp
     * 
     * @param array $data
     * @return void
     */
    public function signUp(StoreUserData $data): UserData;
    
    /**
     * Summary of signIn
     * 
     * @param array $data
     * @return void
     */
    public function signIn(SignInUserData $data): ?array;

}
