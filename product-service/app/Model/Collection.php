<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Collection extends BaseModel
{
    public $incrementing = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
        ];
    }
}
