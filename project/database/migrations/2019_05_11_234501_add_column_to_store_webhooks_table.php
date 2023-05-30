<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToStoreWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_webhooks', function (Blueprint $table) {
            $table->bigInteger('shopify_webhook_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_webhooks', function (Blueprint $table) {
            $table->dropColumn('shopify_webhook_id');
        });

    }
}
