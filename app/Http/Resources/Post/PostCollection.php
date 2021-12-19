<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\AbstractCollection;

class PostCollection extends AbstractCollection
{
    private const RESOURCE_COLLECTION_NAME = 'posts';

    public function toArray($request)
    {
        $this->setCollectionName(self::RESOURCE_COLLECTION_NAME);

        return [
            'data' => $this->buildDataStructure($this->collection, $request),
        ];
    }
}
