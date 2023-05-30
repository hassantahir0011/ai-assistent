<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingShopifyWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_shopify_webhooks', function (Blueprint $table) {
            $table->bigIncrements('id');
            // in case of order it will be order id while for customers object it will be  customer id in shopify store
            $table->bigInteger('object_id');
            $table->bigInteger('shop_id');
            $table->string('topic_name');
            $table->dateTime('shopify_updated_at')->nullable();
            $table->timestamps();
            $table->unique(['object_id', 'shop_id','shopify_updated_at','topic_name'],'make_composite_keys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incoming_shopify_webhooks');
    }
}
