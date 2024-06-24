<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Models\Tag;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditTagController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tag  = Tag::find($request->id);
        if (Tag::find($request->id) == null) {
            $error = "Ce tag n'existe pas ou est introuvable";
            return response()->json($error,404);
        }
        if (true) {
            $validator = Validator::make($request->all(),[
                'name' => 'required | string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message'=>$validator->errors()->messages()]);
            }
            $tag->name = $request->name;
            $tag->save();
            $message = "Le nom du tag a bien été modifier";

            return response()->json( $message,201);
        }else{
            $error = "Vous n'avez pas les autorisations requises pour effectuer cette action";
            return response()->json($error);
        }
    }
}
