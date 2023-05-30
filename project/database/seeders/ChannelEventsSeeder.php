<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChannelEventsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        \App\Entities\ChannelEvent::insert($data);
    }
}
