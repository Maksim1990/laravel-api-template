<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\AbstractResource;

class PostResource extends AbstractResource
{
    public function toArray($request)
    {
        return $this->buildDataStructure(
            [
                'id' => $this->id,
                'slug' => $this->slug,
                'title' => $this->title,
                'description' => $this->description,
                'updated_at' => $this->updated_at,
            ],
            $request
        );
    }
}
