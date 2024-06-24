<?php

namespace App\Http\Resources\Admin\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostCreateDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'imagesPath' => $this->imagesPath,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'tags' => $this->tags
        ];
    }
}
