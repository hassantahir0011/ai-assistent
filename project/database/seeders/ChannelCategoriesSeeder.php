<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChannelCategoriesSeeder extends Seeder
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
                'id' =>1,
                'name' => 'Email Providers',
                'details' => Null,
                'status'=>1
            ],
            [
                'id' =>2,
                'name' => 'General CRM',
                'details' => Null,
                'status'=>1
            ],
            [
                'id' =>3,
                'name' => 'Marketing Automation CRM',
                'details' => Null,
                'status'=>1
            ],
            [
                'id' =>4,
                'name' => 'Enterprise CRM',
                'details' => Null,
                'status'=>0
            ],
            [
                'id' =>5,
                'name' => 'Database',
                'details' => Null,
                'status'=>1
            ],
            [
                'id' =>6,
                'name' => 'Sheets',
                'details' => Null,
                'status'=>1
            ],
            [
                'id' =>7,
                'name' => 'Cloud Storage Platform',
                'details' => Null,
                'status'=>0
            ],
            [
                'id' =>8,
                'name' => 'General',
                'details' => Null,
                'status'=>1
            ],
            [
                'id' =>9,
                'name' => 'File Types',
                'details' => Null,
                'status'=>0
            ],
            [
                'id' =>10,
                'name' => 'Books',
                'details' => Null,
                'status'=>1
            ],
            [
                'id' =>11,
                'name' => 'Communication & Notification',
                'details' => Null,
                'status'=>1
            ],
        ];

        \App\Entities\ChannelCategory::insert($data);
    }
}