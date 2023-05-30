<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('shop_id');
            $table->bigInteger('charge_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('domain');
            $table->string('myshopify_domain');
            $table->string('country')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('charge_status')->nullable();
            $table->mediumText('confirmation_url')->nullable();
            $table->boolean('updated_theme_snippet')->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->string('updated_theme_id')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('phone')->nullable();
            $table->string('currency')->nullable();
            $table->string('shop_owner')->nullable();
            $table->string('access_token');
            $table->string('iana_timezone')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('timezone')->nullable();


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
        Schema::dropIfExists('shops');
    }
}
