<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('doc_id')->unsigned();
            $table->string('media_url');
            $table->enum('media_type',['image','video','other_files'])->default('image');

            $table->foreign('doc_id')->references('id')->on('docs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_media');
    }
}
