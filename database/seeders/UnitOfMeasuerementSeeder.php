<?php

namespace Database\Seeders;

use App\Models\UnitOfMeasurement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitOfMeasuerementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UnitOfMeasurement::insert([[
            'name' => 'Meter',
            'description' => 'Ukuran Panjang Aset',
        ],
        [
            'name'=> 'Kilogram',
            'description'=> 'Ukuran Berat Aset',
        ]]);
    }
}