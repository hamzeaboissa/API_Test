<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ReadProductService
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
        return Product::where($query)->get();
    }
}
