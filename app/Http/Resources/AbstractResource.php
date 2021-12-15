<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class AbstractResource extends JsonResource
{
    use ApiResourceTrait;

    protected function buildDataStructure(array $data, Request $request): array
    {
        return $this->processRequestData($data, $request);
    }
}
