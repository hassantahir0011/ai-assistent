<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'public.notifications';
    protected $fillable = ['shop_id', 'marked_as_read', 'notification_type', 'notification_title', 'notification_body'];
}
