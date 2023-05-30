<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    protected $casts = [
        'webhook_data' => 'array'
    ];
    public function shop()
    {
        return $this->belongsTo('App\Entities\Shop', 'shop_id', 'shop_id');
    }
}
