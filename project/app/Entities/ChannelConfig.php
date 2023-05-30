<?php

namespace App\Entities;

use App\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Model;

class ChannelConfig extends Model
{
    use EncryptableDbAttribute;
    protected $encryptable = [
        'post_url'
    ];
    protected $table = 'channel_configs';

    public function webhook_topic()
    {
        return $this->belongsTo('App\Entities\WebhookTopic', 'webhook_topic_id', 'id');
    }

    public function quickbooks_event_settings()
    {
        return $this->hasOne(QuickbooksEventSetting::class, 'channel_config_id', 'id');
    }

//    public function constant_contact_event_settings()
//    {
//        return $this->hasOne(ConstantContactEventSetting::class, 'channel_config_id', 'id');
//    }
    public function channel_event_settings()
    {
        return $this->hasOne(ChannelEventSetting::class, 'channel_config_id', 'id');
    }

}
