<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ReadUserService
{
    /**
     * @param array $requestData
     * @param bool $paginate
     * @return array|Collection
     */

    public function __invoke(array $requestData): array|Collection
    {
        $query = array();
        if (isset($requestData['name'])) {
            $query[] = ['name', '%' . $requestData['name'] . '%'];
        }
        if (isset($requestData['email'])) {
            $query[] = ['name', '%' . $requestData['email'] . '%'];
        }
        return User::where($query)->get();
    }
}
