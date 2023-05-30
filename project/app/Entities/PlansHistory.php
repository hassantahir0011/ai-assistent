<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PlansHistory extends Model
{
    protected $table='plans_history';

    public function shop()
    {
        return $this->belongsTo('App\Entities\Shop','shop_id','id');
    }
}
