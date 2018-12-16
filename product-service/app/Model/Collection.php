<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    public $incrementing = false;

    //
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
