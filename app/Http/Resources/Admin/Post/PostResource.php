<?php

namespace App\Http\Resources\Admin\Post;

use App\Http\Resources\Admin\Tag\TagResource;
use App\Http\Resources\Public\Comment\CommentResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $post  = Post::find($this->id);
        $user = $post->user->name;
        $category = $post->category->name;
        return [
                'id' => $this->id,
                'title' => $this->title,
                'slug' => $this->slug,
                'content' => $this->content,
                'image' => $this->imagesPath,
                'owner' => $user ,
                'category'=> $category ,
                'tags' => TagResource::collection($this->whenLoaded('tags')),
                'comments'=>CommentResource::collection($this->whenLoaded('comments')),
                'date'=> $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
