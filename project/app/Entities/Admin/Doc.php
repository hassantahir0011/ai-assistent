<?php

namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    public function event()
    {
        return $this->belongsTo('App\Entities\WebhookEvent', 'webhook_event_id', 'id');
    }
    public function media()
    {
        return $this->hasMany('App\Entities\Admin\DocMedia', 'doc_id', 'id');
    }
}
