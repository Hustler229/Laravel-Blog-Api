<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Resources\Admin\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserSwitchRuleController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->user()->rule == 'admin') {
            if (User::find($request->id) !== null) {
                $user = User::find($request->id);

                $validator = Validator::make($request->all(),[
                    'rule' => 'required|string',
                ]);


                if ($validator->fails()) {
                    return response()->json($validator->errors()->messages());
                }


                $validated = $validator->valid();

                if ($validated['rule'] !== 'admin' && $validated['rule']!=='default') {
                    $message = "Ce rôle n'existe pas";
                    return response()->json($message);
                }


                $user->rule = $validated['rule'];
                $user->save();
                $name = $user->name;
                $message = "Le rôle du compte ".$name." a bien été modifié";
                return response()->json([new UserResource($user), $message]);

            }else{
                $message = "L'utilisateur est introuvable ou n'existe pas";
                return response()->json($message);
            }
        }else{
            $message = "Vous n'avez pas les autorisations requises pour effectuer cette action";

            return response()->json($message);
        }
    }
}
