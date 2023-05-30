<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class WebhookEvent extends Model
{
    protected $table = 'public.webhook_events';

    public function topics()
    {
        return $this->hasMany('App\Entities\WebhookTopic', 'webhook_event_id', 'id')
            ->where('topic_status','enabled');
    }

    public function docs()
    {
        return $this->hasOne('App\Entities\Admin\Doc', 'webhook_event_id', 'id');

    }
}
