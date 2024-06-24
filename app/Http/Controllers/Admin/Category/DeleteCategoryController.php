<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;

class DeleteCategoryController
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
            $name = $category->name;
            $category->delete();
            $message = "La catégorie ".$name." a bien été supprimé";
            return response()->json($message);
        }else{
            $error = "Vous n'avez pas les autorisations requises pour effectuer cette action";
            return response()->json($error);
        }
    }
}
