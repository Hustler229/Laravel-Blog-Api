<?php

namespace App\Http\Controllers\Admin\Post;

use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class EditPostController
{
    public function __invoke(Request $request)
    {

        function SlugData($data)
        {
            return Str::slug($data);
        }

        $post = Post::find($request->id);
        if ((Post::find($request->id) == null)) {
            $error = 'Post Introuvable';
            return response()->json($error, 201);
        }
        if ($post->user_id == $request->user()->id) {
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
            ]);;

            // Retournement d'erreur en cas de faillite de la validation
            if ($validator->fails()) {
                return response()->json([
                    'Title Error' => $validator->errors()->messages()['title'],
                    'Content Error' => $validator->errors()->messages()['content'],
                    'Slug Error' => $validator->errors()->messages()['slug'],
                    'Image Path Error' => $validator->errors()->messages()['imagesPath'],
                    'Category ID Error' => $validator->errors()->messages()['category_id'],
                ]);
            }

            // Validation des données vérifier

            $post->title = $request['title'];
            $post->content = $request['content'];
            $post->slug = $request['slug'];
            $post->imagesPath = $request['imagesPath'];
            $post->category_id = $request['category_id'];

            $post->save();
            if (isset($request->tags)) {
                $post->tags()->attach($request['tags']);
            }
            // Retour du post créer
            return response()->json([
                'message' => 'Votre post a été mis à jour avec succès',
                'post' => $post,
                'tags' => $post->tags
            ], 201);
        } else {
            return response()->json([
                'message' => "Vous n'avez pas les autorisations requis pour modifier ce post",
            ]);
        }
    }
}
