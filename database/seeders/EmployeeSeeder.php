<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::insert([[
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