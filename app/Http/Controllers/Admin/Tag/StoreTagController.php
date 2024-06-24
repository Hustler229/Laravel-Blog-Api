<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreTagController
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required | string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->messages()]);
        }
        $validated = $validator->validated();
        $tag = Tag::create($validated);
        $message= "Le tag a été créer avec succès";
        return response()->json( $message,201);
    }
}
