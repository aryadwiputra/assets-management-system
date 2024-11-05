<?php

namespace Database\Seeders;

use App\Models\Warranty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarrantySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warranty::insert([[
            'name' => '1 Pekan',
            'period'=> 7,
        ],[
            'name' => '1 Bulan',
            'period'=> 31,
        ],[
            'name' => '1 Tahun',
            'period'=> 365,
        ]]);
    }
}