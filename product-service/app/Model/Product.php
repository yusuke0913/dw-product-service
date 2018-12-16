<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $incrementing = false;

    //
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}
