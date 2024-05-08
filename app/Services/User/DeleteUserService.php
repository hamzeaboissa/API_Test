<?php

namespace App\Services\User;

use App\Models\User;

class DeleteUserService
{
    /**
     * @param User $user
     * @return User
     */
    public function __invoke(User $user): User
    {
        $user->delete();
        return $user;
    }
}
