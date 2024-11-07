<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([[
            'name' => 'Aktif',
            'description' => 'Status Asset',
        ],
        [
            'name'=> 'Hilang',
            'description'=> 'Status Penghapusan Asset',
        ]]);
    }
}