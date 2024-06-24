<?php

namespace App\Http\Controllers\Admin\Tag;

use App\Http\Resources\Admin\Tag\TagCollection;
use App\Models\Tag;
use Illuminate\Http\Request;

class IndexTagController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tags = new TagCollection(Tag::all());

        return response()->json($tags);
    }
}
