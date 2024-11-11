<?php

namespace Database\Seeders;

use App\Models\PersonInCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonInChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersonInCharge::insert([[
            'project_id' => '1',
            'department_id' => '1',
            'name' => 'PIC IT',
        ], [
            'project_id'=> '1',
            'department_id' => '1',
            'name'=> 'PIC Marketing',
        ]]);
    }
}