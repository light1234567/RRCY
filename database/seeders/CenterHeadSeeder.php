<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterHeadSeeder extends Seeder
{
    public function run()
    {
        DB::table('center_heads')->insert([
            'center_head_name' => 'ANGELIC B. PAÑA',
        ]);
    }
}
