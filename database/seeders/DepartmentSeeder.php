<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert([[
            'name' => 'IT',
            'description'=> 'Departement yang berfokus pada IT',
        ], [
            'name'=> 'Marketing',
            'description'=> 'Departement yang berfokus pada Marketing',
        ]]);
    }
}