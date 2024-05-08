<?php

namespace App\Services\Category;

use App\Models\Category;

class DeleteCategoryService
{
    /**
     * @param Category $Category
     * @return Category
     */
    public function __invoke(Category $Category): Category
    {
        $Category->delete();
        return $Category;
    }
}
