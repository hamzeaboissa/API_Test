<?php

namespace App\Services\Category;

use App\Models\Category;

class CreateCategoryService
{
    /**
     * @param array $requestData
     * @return Category
     */
    public function __invoke(array $requestData): Category
    {
        $Category = new Category();

        $Category->name = $requestData['name'];
        $Category->save();

        return $Category;
    }
}
