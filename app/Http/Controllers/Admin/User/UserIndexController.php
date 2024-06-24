<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Resources\Admin\User\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserIndexController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return new UserCollection(
            User::query()
                        ->paginate(10)
        );
    }
}
