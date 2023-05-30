<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_history', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('shop_id');
            $table->bigInteger('charge_id')->nullable();
            $table->mediumText('confirmation_url')->nullable();
            $table->enum('plan_type',['basic','professional','elite']);
            $table->string('charge_status')->nullable();
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
        Schema::dropIfExists('plans_history');
    }
}
