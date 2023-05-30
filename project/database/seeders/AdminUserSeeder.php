<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \App\Entities\User::firstOrCreate(
            ['email' => 'hassan.tahir0011@gmail.com'

            ], [
                'name' => 'Hassan Tahir',
                'password' => bcrypt('123456'),
            ]
        );
    }
}
