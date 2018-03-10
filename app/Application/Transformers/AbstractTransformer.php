<?php

namespace App\Application\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractTransformer
{
    protected $options;
    /**
     * Initialize transformer.
     *
     * @param $options
     */
    private function __construct($options)
    {
        $this->options = $options;
    }
    /**
     * Transform a Model or a Collection.
     *
     * @param mixed $modelOrCollection
     * @param array $options
     *
     * @return mixed
     */
    static function transform($modelOrCollection, $options = [])
    {
        $static = new static($options);

        if ($modelOrCollection instanceof Collection) {
            return $modelOrCollection->map([$static, 'transformModel'])->toArray();
        }

        if ($modelOrCollection instanceof LengthAwarePaginator) {
            return $modelOrCollection->map([$static, 'transformModel'])->toArray();
        }

        return $static->transformModel($modelOrCollection);
    }

    static function transformAr($modelOrCollection, $options = [])
    {
        $static = new static($options);
        if ($modelOrCollection instanceof Collection) {
            return $modelOrCollection->map([$static, 'transformModelAr'])->toArray();
        }

        if ($modelOrCollection instanceof LengthAwarePaginator) {
            return $modelOrCollection->map([$static, 'transformModelAr'])->toArray();
        }

        return $static->transformModelAr($modelOrCollection);
    }
    /**
     * Check if the model instance is loaded from the provided pivot table.
     *
     * @param Model $item
     * @param string $tableName
     *
     * @return bool
     */
    protected function isLoadedFromPivotTable(Model $item, $tableName)
    {
        return $item->pivot && $item->pivot->getTable() == $tableName;
    }
    /**
     * Check if the provided relationship is loaded.
     *
     * @param Model $item
     * @param string $relationshipName
     *
     * @return bool
     */
    protected function isRelationshipLoaded(Model $item, $relationshipName)
    {
        return $item->relationLoaded($relationshipName);
    }
    /**
     * Transform the provided model.
     *
     * @return mixed
     */
    protected function transformModel(Model $modelOrCollection)
    {
    }
    protected function transformModelAr(Model $modelOrCollection)
    {
    }
}