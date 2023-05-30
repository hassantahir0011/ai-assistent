<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteConnectorWithWebhookEvent extends Model
{
    use HasFactory;
    protected $fillable = ['channel_id', 'webhook_event_id', 'message'];
    public function webhook_event()
    {
        return $this->belongsTo('App\Entities\WebhookEvent', 'webhook_event_id', 'id');
    }
}
