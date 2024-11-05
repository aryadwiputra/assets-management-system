<?php

namespace Database\Seeders;

use App\Models\AssetUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssetUser::insert([[
            'name' => 'Susi Susanti',
            'description' => 'Susi susanti',
        ], [
            'name' => 'Budi Sudarsono',
            'description' => 'Budi sudarsono',
        ], [
            'name' => 'Arya Dwi Putra',
            'description' => 'Arya dwi putra',
        ], [
            'name' => 'Maulana',
            'description' => 'Maulana',
        ]]);
    }
}