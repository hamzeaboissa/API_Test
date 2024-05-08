<?php

namespace App\Services\Product;

use App\Models\Product;

class UpdateProductService
{
    /**
     * @param array $requestData
     * @param Product $Product
     * @return Product
     */
    public function __invoke(array $requestData, Product $Product): Product
    {
        $Product->update($requestData);
        return $Product;
    }
}
