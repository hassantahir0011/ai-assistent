<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteConnectorWithWebhookEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_connector_with_webhook_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('webhook_event_id')->nullable();
            $table->longText('message')->nullable();
            $table->timestamps();
            $table->foreign('webhook_event_id')->references('id')->on('webhook_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite_connector_with_webhook_events');
    }
}
