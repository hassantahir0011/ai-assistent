<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelEventSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_event_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('channel_account_id')->unsigned();
            $table->bigInteger('channel_config_id');
            $table->bigInteger('channel_event_id')->unsigned();
            $table->string('object_id')->nullable();
            $table->string('object_text')->nullable();
            $table->longText('api_fields');
            $table->timestamps();

            $table->foreign('channel_account_id')->references('id')->on('channel_accounts') ->onDelete('cascade');
//            $table->foreign('channel_event_id')->references('id')->on('channel_events') ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_event_settings');
    }
}
