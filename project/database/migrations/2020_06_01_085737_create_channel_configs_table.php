<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('channel_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('post_url')->nullable();
            $table->integer('webhook_topic_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->bigInteger('shop_id');

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
        Schema::dropIfExists('channel_configs');
    }
}
