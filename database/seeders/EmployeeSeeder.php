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
        Employee::insert([
            'project_id' => '1',
            'department_id' => '1',
            'name' => 'Susi Susanti',
        ]);

        Employee::insert([
            'project_id' => '1',
            'department_id' => '1',
            'name' => 'Budi Hartono',
        ]);
    }
}