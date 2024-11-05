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
            'name' => 'Andalusia Residence',
            'slug' => 'andalusia-residence',
            'description'=> 'Perumahan Andalusia Residence',
            'address' => 'Jalan Andalusia Residence',
            'is_active' => 1
        ]);
    }
}