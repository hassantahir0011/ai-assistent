<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnsToChannelConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel_configs', function (Blueprint $table) {
            $table->boolean('send_system_defined_notifcation')->default(0);
            $table->text('message_title')->nullable();
            $table->longText('message_body')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channel_configs', function (Blueprint $table) {
            $table->dropColumn('send_system_defined_notifcation');
            $table->dropColumn('message_title');
            $table->dropColumn('message_body');
        });
    }
}
