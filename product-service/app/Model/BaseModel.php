<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BaseModel extends Model
{
    protected function getTimestampsAttributes()
    {
        if (!$this->timestamps) {
            return [];
        }

        return [
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now(),
        ];
    }

    /**
     *
     *   @param self $models
     * * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function bulkInsert($models)
    {
        $attributes = collect();
        foreach ($models as $model) {
            $attribute = array_merge($model->toArray(), $model->getTimestampsAttributes());
            $attributes[] = array_merge($model->toArray(), $model->getTimestampsAttributes());
        }
        self::insert($attributes->toArray());
    }

    public static function allByMapWithKeys()
    {
        return self::all()->mapWithKeys(function ($model) {
            $pk = $model->primaryKey;
            return [ $model->$pk => $model];
        });
    }
}
