<?php

namespace App\Http\Controllers\Public\Post;

use App\Http\Resources\Public\Post\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class PublicPostController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Post::query();

        if ($search = $request->search) {
            $value = $request->search;
            $posts->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('content', 'LIKE', '%' . $search . '%');
        }
        return  new PostCollection(
            $posts
                ->with(['tags','comments'])
                ->latest()
                ->paginate(10)
        );
    }
}
