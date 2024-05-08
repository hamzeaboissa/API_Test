<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ReadCategoryService
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
        return Category::where($query)->get();
    }
}
