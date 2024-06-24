<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\Admin\User\UserResource;
use Illuminate\Http\Request;

class ProfilCredentialsController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user  = $request->user();

        return new UserResource(
            $user
        );
    }
}
