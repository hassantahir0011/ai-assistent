<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['shop_id', 'domain', 'access_token'];

    public function webhook_topics()
    {
        return $this->belongsToMany('App\Entities\WebhookTopic', 'store_webhooks', 'shop_id', 'webhook_topic_id');
    }

    public function webhook_logs()
    {
        return $this->hasMany('App\Entities\WebhookLog', 'shop_id', 'shop_id');
    }
    public function processed_jobs()
    {
        return $this->hasMany('App\Entities\ProcessedJob', 'shop_id', 'shop_id');
    }
    public function plans_history()
    {
        return $this->hasMany('App\Entities\PlansHistory', 'shop_id', 'shop_id');
    }

    public function channels()
    {
        return $this->hasMany('App\Entities\ChannelConfig', 'shop_id', 'shop_id');
    }

    public function registeredEventsAndChannels()
    {
        return $this->hasMany('App\Entities\ChannelConfig', 'shop_id', 'shop_id');

    }
}
