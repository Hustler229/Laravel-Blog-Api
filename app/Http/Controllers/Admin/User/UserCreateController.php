<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCreateController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages());
        }
        $request['password'] = Hash::make($request['password']);
        $validated = $validator->valid();
        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;
        $message = "Le compte a bien été créer";
        return response()->json(
            [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'message' => $message
            ]
        );


    }
}
