<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\AbstractResource;

class UserResource extends AbstractResource
{
    public function toArray($request)
    {
        return $this->buildDataStructure(
            [
                'id' => $this->id,
                'email' => $this->email,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            $request
        );
    }
}
