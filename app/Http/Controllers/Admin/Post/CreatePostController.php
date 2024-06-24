<?php

namespace App\Http\Controllers\Admin\Post;

use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CreatePostController
{
    public function __invoke(Request $request)
    {

        // Fonction pour slugifier un texte
        function SlugData($data)
        {
            return Str::slug($data);
        }



        // Validation des images et enregistrement dans le dossier public génération d'un chemin d'accès ou non pour chaque image enregistrée
        // $image = $request->file('imagesPath');
        // $fileName = $request['imagesPath'];
        // $destinationPath = public_path('/images');
        // $image->move($destinationPath, $fileName);
        // $request['imagesPath'] = $fileName;
        // Condition pour slugifier le slug d'un post si celui qui enregistre l post entre un slug personnalisé ou pas
        if (isset($request->slug)) {
            $request['slug'] = SlugData($request->slug);
        } else {
            $request['slug']  = SlugData($request->title);
        }
        $request['user_id'] = $request->user()->id;

        // Validaton des données avant de les enregistrées
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'slug' => 'required|string',
            'imagesPath' => 'required|string',
            'user_id' => 'required',
            'category_id' => 'required',
            'tags' => ''
        ]);

        // Retournement d'erreur en cas de faillite de la validation
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()->messages()
                ]
            );
        }

        // Validation des données vérifier
        $validated = $validator->validated();


        // Création d'un post et rattachement des tags qui lui sont attribués au cas où il en reçoit
        $post = Post::create($validated);
        if (isset($request->tags)) {
            $post->tags()->attach($request['tags']);
        }
        // Retour du post créer
        return response()->json($post, 201);
    }
}
