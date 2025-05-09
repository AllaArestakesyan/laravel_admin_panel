<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Models\User;
use Hash;

class AuthService implements AuthServiceInterface
{
    /**
     * Summary of signUp
     * 
     * @param array $data
     * @return User
     */
    public function signUp(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }


    /**
     * Summary of signIn
     * 
     * @param array $data
     * @return array{access_token: mixed, token_type: string|null}
     */
    public function signIn(array $data): ?array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user['password'])) {

            return null;
        }
        $token = $user->createToken('api-token')->plainTextToken;

        return [
                'access_token' => $token,
                'token_type' => 'Bearer',
        ];
    }
}