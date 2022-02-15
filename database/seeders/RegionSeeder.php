<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regionsQuantity = 20;

        for ($i = 1; $i <= $regionsQuantity; $i++) {
            $date = date('Y-m-d H:i:s');

            DB::table('regions')->insert([
                'id' => $i,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
