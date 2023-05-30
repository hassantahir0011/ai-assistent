<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            // in case of order it will be order id while for customers object it will be  customer id in shopify store
            $table->string('object_id');
            $table->bigInteger('shop_id');
            $table->integer('webhook_topic_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->dateTime('shopify_updated_at')->nullable();
            $table->timestamps();
            //$table->unique(['object_id', 'shop_id','shopify_updated_at','channel_id'],'make_composite_keys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhook_logs');
    }
}
