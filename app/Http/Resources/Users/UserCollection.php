<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\AbstractCollection;

class UserCollection extends AbstractCollection
{
    private const RESOURCE_COLLECTION_NAME = 'users';

    public function toArray($request)
    {
        $this->setCollectionName(self::RESOURCE_COLLECTION_NAME);

        return [
            'data' => $this->buildDataStructure($this->collection, $request),
        ];
    }
}
