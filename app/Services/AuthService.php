<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Data\SignInUserData;
use App\Data\StoreUserData;
use App\Data\UserData;
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
    public function signUp(StoreUserData $data): UserData
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        return UserData::from($user);
    }


    /**
     * Summary of signIn
     * 
     * @var User|null $user
     * @param SignInUserData $data
     * @return array{access_token: mixed, token_type: string|null}
     */
    public function signIn(SignInUserData $data): ?array
    {
        $user = User::where('email', $data->email)->first();

        if (!$user || !Hash::check($data->password, $user->password)) {

            return null;
        }
        $token = $user->createToken('api-token')->plainTextToken;

        return [
                'access_token' => $token,
                'token_type' => 'Bearer',
        ];
    }
}