<?php

namespace App\Services\User;

use App\Models\User;

class UpdateUserService
{
    /**
     * @param array $requestData
     * @param User $user
     * @return User
     */
    public function __invoke(array $requestData, User $user): User
    {
        $user->update($requestData);
        return $user;
    }
}
