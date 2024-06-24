<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();


        $token = $request->user()->createToken('api-token');


        return response()->json(['token' => $token->plainTextToken]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {

        $user = $request->user();

       
        $user->tokens()->delete();

        return response()->noContent();
    }
}
