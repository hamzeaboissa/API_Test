<?php

namespace App\Services\Product;

use App\Models\Product;

class DeleteProductService
{
    /**
     * @param Product $Product
     * @return Product
     */
    public function __invoke(Product $Product): Product
    {
        $Product->delete();
        return $Product;
    }
}
