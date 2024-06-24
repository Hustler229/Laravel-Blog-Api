<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditCategoryController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $category = Category::find($request->id);
        if(Category::find($request->id) == null){
            $error = "La catégorie n'existe pas ou est introuvable.";
            return response()->json($error,404);
        }
        if($request->user()->rule == 'admin'){
            $validator = Validator::make($request->all(),[
                'name' => 'required | string',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->messages()]);
            }
            $category->name = $request->name;
            $category->save();

            return response()->json('Le nom de la catégorie  été modifié avec succès');
        }else{
            return response()->json("Vous n'avez pas les autorisations requises pour effectuer cette action");
        }
    }
}
