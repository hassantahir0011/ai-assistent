<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhookTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('webhook_event_id');
            $table->string('topic_name');
            $table->string('webhook_topic_url');
            $table->enum('topic_status',['enabled','disabled'])->default('enabled');
            $table->integer('updated_by')->nullable();
            //$table->foreign('webhook_event_id')->references('id')->on('webhook_events')->onDelete('cascade');
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
        Schema::dropIfExists('webhook_topics');
    }
}
