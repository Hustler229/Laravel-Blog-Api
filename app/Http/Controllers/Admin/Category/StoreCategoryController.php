<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreCategoryController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->user()->rule == 'admin') {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->messages()]);
            }
            $validated = $validator->valid();
        
            $category = Category::create($validated['name']);

            return response()->json( $category,201);
        }else{
            return response()->json([
                'message' => "Vous n'avez pas les autorisations requises pour effectuer cette action"
            ]);
        }
    }
}
