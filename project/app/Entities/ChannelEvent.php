<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ChannelEvent extends Model
{
    protected $table = 'public.channel_events';
//
//    public function hubspot_event_settings()
//    {
//        return $this->hasMany(HubspotEventSetting::class, 'channel_event_id', 'id');
//    }
}
