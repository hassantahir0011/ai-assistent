<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('customer_email')->nullable();
            $table->string('shopify_plan_display_name')->nullable();
            $table->string('province')->nullable();
            $table->string('primary_locale',10)->nullable();
            $table->string('country_name',50)->nullable();
            $table->string('country_code',10)->nullable();
            $table->mediumText('address2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            //
        });
    }
}
