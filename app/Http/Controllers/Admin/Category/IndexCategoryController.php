<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Resources\Admin\Category\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexCategoryController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $category = new CategoryCollection(Category::query()->get());

        return response()->json(array('category' => $category));
    }
}
