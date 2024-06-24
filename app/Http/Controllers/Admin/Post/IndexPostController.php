<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Resources\Admin\Post\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexPostController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return new PostCollection(
            Post::query()->with(['tags','comments'])
                                    ->where('user_id',  '=' , $request->user()->id)
                                    ->paginate(10)
        );
    }
}
