<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed','min:6', Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => strtolower($request->email),
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token], 201);
}

}
