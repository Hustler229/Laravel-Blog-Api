<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UpdateCredentialsController
{
    public function update_user_name(Request $request)
    {

        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error message' => $validator->errors()->messages(),
                ]
            );
        }
        $validated =  $validator->valid();
        $name = $validated['name'];
        $user->name = $name;
        $user->save();
        return response()->json(
            [
                'message' => 'Your name has been changed'
            ]
        );
    }

    public function update_user_email(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|unique:users|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors()->messages(),
                ],
                422
            );
        }

        $email = $validator->validated()['email'];
        $user->email = strtolower($email);
        $user->email_verified_at = null; // Demander une nouvelle vérification
        $user->save();

        // Envoyer la notification de vérification d'email
        $user->sendEmailVerificationNotification();

        return response()->json(
            [
                'message' => 'Your email has been changed and needs to be verified.'
            ],
            200
        );
    }


    public function update_user_password(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors()->messages(),
                ],
                422
            );
        }

        $password = Hash::make($request->password);
        $user->password = $password;
        $user->remember_token = Str::random(60); // Réinitialiser le remember_token
        $user->save();

        return response()->json(
            [
                'message' => 'Your password has been changed. Please log in again.'
            ],
            200
        );
    }
}
