<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableDbAttribute;

class CustomApp extends Model
{
    use EncryptableDbAttribute;

    protected $encryptable = ['login_credentials'];


    protected $fillable = ['shop_id','login_credentials','channel_id'];

}
