<?php
namespace App\Utils;

class ModelUtil
{
    public static function getRandomModelId(string $model): ?int
    {
        $modelIds = $model::all()->pluck('id')->toArray();

        if(empty($modelIds)) {
            return null;
        }

        return $modelIds[array_rand($modelIds)];
    }
}
