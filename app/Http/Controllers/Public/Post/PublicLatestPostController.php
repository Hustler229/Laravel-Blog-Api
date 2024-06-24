<?php

namespace App\Http\Controllers\Public\Post;

use App\Http\Resources\Public\Post\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class PublicLatestPostController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return new PostCollection(
            Post::query()
            ->orderBy('id','desc')
            ->limit(9)
            ->get()
        );
    }
}
