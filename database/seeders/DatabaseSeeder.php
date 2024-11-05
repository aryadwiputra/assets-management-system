<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Location;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            CompanySeeder::class,
            ProjectSeeder::class,
            ClassSeeder::class,
            StatusSeeder::class,
            CategorySeeder::class,
            DepartmentSeeder::class,
            UnitOfMeasuerementSeeder::class,
            PersonInChargeSeeder::class,
            EmployeeSeeder::class,
            LocationSeeder::class,
            WarrantySeeder::class,
        ]);
    }
}