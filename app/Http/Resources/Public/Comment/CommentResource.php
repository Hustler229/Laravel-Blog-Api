<?php

namespace App\Http\Resources\Public\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $author = $this->user->name;
        return [
            'comment' => $this->content,
            'author' => $author
        ];
    }
}
