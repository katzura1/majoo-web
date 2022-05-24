<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert(
            [
                [
                    'id' => '1',
                    'name' => 'Pro',
                ],
                [
                    'id' => '2',
                    'name' => 'Standart',
                ],
            ]
        );
    }
}
