<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert(
            [
                [
                    'name' => 'Denny',
                    'email' => 'denny@gmail.com',
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                ],
                [
                    'name' => 'Budi',
                    'email' => 'budi@gmail.com',
                    'password' => password_hash('123456', PASSWORD_DEFAULT),
                ]
            ]
        );
    }
}
