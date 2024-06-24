<?php

namespace App\Http\Controllers\Public\Post;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentAppendingController
{
    public function new_comment(Request $request)
    {
        $request['user_id'] = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'user_id' => 'integer',
            'post_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors()->messages()
                ]
            );
        }
        $validated = $validator->valid();

        Comment::create($validated);

        return response()->json(
            [
                'message' => "Votre commentaire a bien été enregistré",
            ]
        );
    }

    public function delete_comment(Request $request)
    {
        $user_id = $request->user()->id;
        $comment = Comment::find($request->id);

        if (!$comment) {
            return response()->json(
                ['message' => "Le commentaire n'existe pas"],
                404
            );
        }

        if ($user_id != $comment->user_id) {
            return response()->json(
                ['message' => "Vous ne pouvez pas effectuer cette action"],
                403
            );
        }

        $comment->delete();
        return response()->json(
            ['message' => "Votre commentaire a bien été supprimé"],
            200
        );
    }
}
