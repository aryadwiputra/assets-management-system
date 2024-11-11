<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::insert([
            "company_id"=> 1,
            'name' => 'Cipta Graha Adijaya',
            'slug' => 'cipta-graha-adijaya',
            'description'=> "Cipta graha adijaya",
        'address' => 'Jalan Graha Raya Regency',
            'is_active' => 1
        ]);
    }
}