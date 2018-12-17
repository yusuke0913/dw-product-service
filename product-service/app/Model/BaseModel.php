<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static function allByMapWithKeys()
    {
        return self::all()->mapWithKeys(function ($model) {
            $pk = $model->primaryKey;
            return [ $model->$pk => $model];
        });
    }
}
