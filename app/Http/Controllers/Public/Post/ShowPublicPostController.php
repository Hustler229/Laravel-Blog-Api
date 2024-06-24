<?php

namespace App\Http\Controllers\Public\Post;

use App\Http\Resources\Public\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class ShowPublicPostController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ((Post::where('slug',$request->slug) !== null)) {
            $post = Post::where('slug',$request->slug)->with(['tags','comments'])->firstOrFail();
            return new PostResource($post);
        }else{
            $error = 'Post Introuvable';
            return response()->json($error, 201);
        }
    }
}
