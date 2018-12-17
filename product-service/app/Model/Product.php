<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    public $incrementing = false;

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'size' => $this->size,
            'collection_id' => $this->collection_id,
        ];
    }
}
