<?php
namespace App\Utils;

class ModelUtil
{
    public static function getRandomModelId(string $model): ?int
    {
        $modelIds = self::getModelIds($model);

        if(empty($modelIds)) {
            return null;
        }

        return $modelIds[array_rand($modelIds)];
    }

    public static function getModelIds(string $model): ?array
    {
        return $model::all()->pluck('id')->toArray();
    }
}
