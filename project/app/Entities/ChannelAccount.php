<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableDbAttribute;

class ChannelAccount extends Model
{
    use EncryptableDbAttribute;
//    protected $casts = ['login_credentials' => 'array' ];
    protected $encryptable = ['login_credentials'];


    protected $fillable = ['shop_id','login_credentials','channel_id','user_id'];

    public function channel_event_settings()
    {
        return $this->hasMany(ChannelEventSetting::class, 'channel_account_id', 'id');
    }
    public function custom_app()
    {
        return $this->hasOne(CustomApp::class, 'id', 'custom_app_id');
    }
}
