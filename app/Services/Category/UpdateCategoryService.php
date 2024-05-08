<?php

namespace App\Services\Category;

use App\Models\Category;

class UpdateCategoryService
{
    /**
     * @param array $requestData
     * @param Category $Category
     * @return Category
     */
    public function __invoke(array $requestData, Category $Category): Category
    {
        $Category->update($requestData);
        return $Category;
    }
}
