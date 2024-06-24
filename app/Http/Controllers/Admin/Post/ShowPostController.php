<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Resources\Admin\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class ShowPostController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ((Post::find($request->id) !== null)) {
            $post = Post::query()->with('tags')->find($request->id);
            return new PostResource($post);
        }else{
            $error = 'Post Introuvable';
            return response()->json($error, 201);
        }
    }
}
