<?php

namespace App\Http\Controllers\Admin\Post;

use App\Models\Post;
use Illuminate\Http\Request;

class DeletePostController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $post = Post::find($request->id);
        if ((Post::find($request->id) == null)) {
            $error = 'Post Introuvable';
            return response()->json($error);
        }
        if ($post->user_id == $request->user()->id) {
            $post->tags()->detach();

            $post->delete();

            if (Post::find($request->id) == null) {
                return response()->json([
                    'message' => "Post supprimer avec succès",
                ]);
            } else {
                return response()->json([
                    'message' => "Le post n'a pas pu été supprimer, un problème est survenue",
                ]);
            }
        }else{
            return response()->json([
                'message' => "Vous n'avez pas les autorisations requises pour supprimer ce post",
            ]);
        }
    }
}
