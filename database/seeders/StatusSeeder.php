<?php

namespace Database\Seeders;

use App\Models\AssetStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AssetStatus::insert([[
            'name' => 'Aktif',
            'description' => 'Status Asset',
        ],
        [
            'name'=> 'Hilang',
            'description'=> 'Status Penghapusan Asset',
        ]]);
    }
}