<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ChannelEventSetting extends Model
{
    protected $casts = ['api_fields' => 'array','where_clause_fields' => 'array'];

    protected $guarded=[];
    public function channel_account()
    {
        return $this->belongsTo(ChannelAccount::class, 'channel_account_id', 'id');
    }

    public function channel_config()
    {
        return $this->belongsTo(ChannelConfig::class, 'channel_config_id', 'id');
    }

    public function channel_event()
    {
        return $this->belongsTo(ChannelEvent::class, 'channel_event_id', 'id');
    }
}
