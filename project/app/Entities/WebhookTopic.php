<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class WebhookTopic extends Model
{
    protected $table = 'public.webhook_topics';
    public function event()
    {
        return $this->belongsTo('App\Entities\WebhookEvent', 'webhook_event_id', 'id');
    }

    public function store_webhooks()
    {
        return $this->hasMany('App\Entities\StoreWebhook',  'webhook_topic_id','id');
    }


    public function channel_configs()
    {
        return $this->hasMany('App\Entities\ChannelConfig',  'webhook_topic_id','id');
    }
}
