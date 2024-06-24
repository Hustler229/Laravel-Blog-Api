<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;

class UserDeleteController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->user()->rule = 'admin') {
            $user  = User::find($request->id);
            if ($user !== null) {
                $name = $user->name;
                $user->delete();
                $message = "Le compte de l'utilisateur ".$name." a bien été supprimer";
                return response()->json($message);

            }else{
                $message = "Le compte ou l'utilisateur est introuvable";
                return response()->json($message);
            }
        }else{
            $message = "Vous n'êtes pas autorisé à effectuer cette action.";

            return response()->json( $message );
        }
    }
}
