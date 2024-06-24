<?php
declare (strict_types=1);
namespace App\functions;

class PostDataObject{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly mixed $slug,
        public readonly mixed $imagesPath,
        public readonly string $user_id,
        public readonly string $category_id,
        public readonly array $tags
    ){}

    public function to_array(){
        return [
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'imagesPath' => $this->imagesPath,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'tags' => $this->tags,
        ];
    }

}
