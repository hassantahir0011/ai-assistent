<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ProcessedJob extends Model
{
    public function shop()
    {
        return $this->belongsTo('App\Entities\Shop', 'shop_id', 'shop_id');
    }
}
