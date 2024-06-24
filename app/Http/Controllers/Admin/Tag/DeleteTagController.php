<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Models\Tag;
use Illuminate\Http\Request;

class DeleteTagController
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

        if($request->user()->rule == 'admin'){
            $name = $tag->name;
            $tag->delete();
            $message = "Le tag ".$name." a été supprimer avec succès";
            return response()->json($message);
        }else{
            $error = "Vous n'avez pas les autorisations requises pour effectuer cette action";
            return response()->json($error);
        }
    }
}
