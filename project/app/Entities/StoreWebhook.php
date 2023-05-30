<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StoreWebhook extends Model
{
    public function topics()
    {
        return $this->hasMany('App\Entities\WebhookTopic', 'webhook_event_id', 'id');
    }
}
