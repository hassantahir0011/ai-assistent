<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

        $this->call(WebhookEventsSeeder::class);
        $this->call(WebhookTopicsSeeder::class);

        $this->call(ChannelEventsSeeder::class);

        $this->call(AdminUserSeeder::class);
        $this->call(DripEventsSeeder::class);
       }
}