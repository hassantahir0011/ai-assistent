<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopifyApiVersionUpdate extends Model
{
    use HasFactory;

    protected $table = 'public.shopify_api_version_updates';
    protected $casts = [
        'payload' => 'array'
    ];
    protected $fillable = ['title', 'description', 'payload', 'status'];
}
