<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnToChannelEventSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel_event_settings', function (Blueprint $table) {
//            $table->dropForeign(['channel_event_id']);
            DB::select( DB::raw("ALTER TABLE channel_event_settings ALTER COLUMN channel_event_id TYPE integer") );
            DB::select( DB::raw("ALTER TABLE channel_event_settings ALTER COLUMN channel_event_id DROP NOT NULL") );
//            DB::select( DB::raw("ALTER TABLE `channel_event_settings` CHANGE COLUMN `channel_event_id` `channel_event_id` BIGINT(20) UNSIGNED NULL AFTER `channel_config_id`") );
        });
        Schema::table('channel_event_settings', function (Blueprint $table) {
//            $table->bigInteger('channel_event_id')->nullable()->change();
            $table->longText('where_clause_fields')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('channel_event_settings', function (Blueprint $table) {
            //
        });
    }
}
