<?php

namespace App\Http\Controllers\Public\Post;

use App\Http\Resources\Public\Post\PostCollection;
use App\Models\Category;
use App\Models\Post;


class FilterPostController
{
    public function filter_post_by_category()
    {
        $categoriesWithPosts = Category::with(['posts.tags', 'posts.comments'])->get();


        $response = [];
        foreach ($categoriesWithPosts as $category) {
            $response[$category->name] = new PostCollection($category->posts);
        }


        return response()->json($response);
    }
}
