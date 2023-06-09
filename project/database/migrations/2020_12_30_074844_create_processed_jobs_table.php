<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_id');
            $table->bigInteger('tokens');
            $table->enum('media_type',['image','video','text','file','other'])->default('other');
            $table->enum('transaction_type',['credit','debit','other'])->default('other');
            $table->index(['shop_id', 'tokens', 'media_type', 'transaction_type']);
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
        Schema::dropIfExists('processed_jobs');
    }
}
