<?php

use App\Http\Controllers\Public\Post\PublicPostController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get(
    '/login',function (Request $request) {
        $user = User::find(22);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
)->name('login');
Route::get('/', PublicPostController::class)->name('index_post');
