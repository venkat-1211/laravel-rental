<?php

namespace Modules\Shared\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Shared\Data\GenericFormData;

class HandleFormSubmission
{
    public function create(GenericFormData $data, string $moduleName, string $model): Model
    {
        $modelClass = "Modules\\$moduleName\\Models\\$model";

        return $modelClass::create($data->all());
    }

    public function update(GenericFormData $data, Model $model): Model
    {
        $model->update($data->all());

        return $model;
    }

    public function delete(Model $model): Model
    {
        $model->delete();

        return $model;
    }

    public function forceDelete(Model $model): Model
    {
        $model->forceDelete();

        return $model;
    }

    public function updateOrCreate(GenericFormData $data, string $moduleName, string $model, array $searchFields): Model
    {
        $modelClass = "Modules\\$moduleName\\Models\\$model";

        return $modelClass::updateOrCreate($searchFields, $data->all());
    }

    // Many To Many
    public function attach(Model $model, string $relation, array $data): Model
    {
        if (! method_exists($model, $relation)) {
            throw new \Exception("Relation '$relation' does not exist on model ".get_class($model));
        }

        $model->$relation()->attach($data);

        return $model;
    }

    public function sync(Model $model, string $relation, array $data): Model
    {
        if (! method_exists($model, $relation)) {
            throw new \Exception("Relation '$relation' does not exist on model ".get_class($model));
        }

        $model->$relation()->syncWithoutDetaching($data);

        return $model;
    }

    public function detach(Model $model, string $relation, array $data = []): Model
    {
        if (! method_exists($model, $relation)) {
            throw new \Exception("Relation '$relation' does not exist on model ".get_class($model));
        }

        $model->$relation()->detach($data);

        return $model;
    }

    /**
     * Create multiple child records in a One-to-Many relationship.
     */
    public function createChildren(Model $parent, string $relation, array $childrenData): Model
    {
        if (! method_exists($parent, $relation)) {
            throw new \Exception("Relation '$relation' does not exist on model ".get_class($parent));
        }

        foreach ($childrenData as $childData) {
            $parent->$relation()->create($childData);
        }

        return $parent;
    }

    /**
     * Update existing or create new child records in a One-to-Many relationship.
     */
    public function updateChildren(Model $parent, string $relation, array $childrenData, string $key = 'id'): Model
    {
        if (! method_exists($parent, $relation)) {
            throw new \Exception("Relation '$relation' does not exist on model ".get_class($parent));
        }

        $relationModel = $parent->$relation()->getRelated();
        $existingChildren = $parent->$relation()->pluck($key)->toArray();
        $inputChildren = collect($childrenData)->pluck($key)->filter()->toArray();

        // Delete removed children
        $toDelete = array_diff($existingChildren, $inputChildren);
        if (! empty($toDelete)) {
            $relationModel::destroy($toDelete);
        }

        // Update or create
        foreach ($childrenData as $child) {
            if (isset($child[$key])) {
                $relationModel::where($key, $child[$key])->update($child);
            } else {
                $parent->$relation()->create($child);
            }
        }

        return $parent;
    }

    /**
     * Delete all or selected children in a One-to-Many relationship.
     */
    public function deleteChildren(Model $parent, string $relation, array $ids = []): Model
    {
        if (! method_exists($parent, $relation)) {
            throw new \Exception("Relation '$relation' does not exist on model ".get_class($parent));
        }

        $query = $parent->$relation();

        if (! empty($ids)) {
            $query->whereIn('id', $ids)->delete();
        } else {
            $query->delete(); // delete all
        }

        return $parent;
    }
}
