<?php

namespace App\Services\Product;

use App\Models\Product;

class CreateProductService
{
    /**
     * @param array $requestData
     * @return Product
     */
    public function __invoke(array $requestData): Product
    {
        $Product = Product::create($requestData);
        return $Product;
    }
}
