<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_webhooks', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('shop_id');

            $table->integer('webhook_topic_id');

          //  $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            //$table->foreign('webhook_topic_id')->references('id')->on('webhook_topics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_webhooks');
    }
}
