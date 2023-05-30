<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DripEventsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $data = [
           [
                'name' => 'Add or Update Subscriber',
                'slug' => 'add_or_update_subscriber',
                'status'=>1,
            ],
            [
                'name' => 'Add people to Campaign',
                'slug' => 'add_people_to_campaign',
                'status'=>1,
            ],
            [
                'name' => 'Remove people from Campaign',
                'slug' => 'remove_people_from_campaign',
                'status'=>1,
            ],
            [
                'name' => 'Add tag to Subscriber',
                'slug' => 'add_tag_to_subscriber',
                'status'=>1,
            ],
            [
                'name' => 'Remove tag from Subscriber',
                'slug' => 'remove_tag_from_subscriber',
                'status'=>1,
            ]


        ];
        \App\Entities\ChannelEvent::insert($data);
    }
}
