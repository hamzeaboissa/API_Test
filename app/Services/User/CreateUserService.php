<?php

namespace App\Services\User;

use App\Models\User;

class CreateUserService
{
    /**
     * @param array $requestData
     * @return User
     */
    public function __invoke(array $requestData): User
    {
        $user = new User();

        $user->name = $requestData['name'];
        $user->email = $requestData['email'];
        $user->password = bcrypt($requestData['password']);
        $user->save();

        return $user;
    }
}
