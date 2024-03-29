<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

abstract class AbstractCollection extends ResourceCollection
{
    use ApiResourceTrait;

    public const DEFAULT_ITEMS_NUMBER_PER_PAGE = 10;
    public const PER_PAGE_PARAM_NAME = 'perPage';
    public const RELATIONS_PARAM_NAME = 'relationships';
    public const RELATIONS_PER_PAGE_PARAM_NAME = 'relationPerPage';

    protected string $collectionName;

    protected function setCollectionName(string $collectionName)
    {
        $this->collectionName = $collectionName;
    }

    protected function buildDataStructure(Collection $collection, Request $request): Collection
    {
        return $collection->map(
            function (AbstractResource $model) use ($request) {

                $resp = ['type' => $this->collectionName, 'id' => $model->id];

                $resp['attributes'] = $model->makeHidden(['id'])->toArray();

                return $this->processRequestData($resp, $request, $model);
            }
        );
    }
}
