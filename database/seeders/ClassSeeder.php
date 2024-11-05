<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Class;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::insert([
            [
                'name' => 'Kelas 1',
                'description' => 'Aset kelas 1 adalah seluruh aset yang memiliki nilai di atas Rp. 50.000.000'
            ],[
                'name'=> 'Kelas 2',
                'description'=> 'Aset kelas 2 adalah seluruh aset yang memiliki nilai diatas Rp. 25.000.000'
            ],[
                'name'=> 'Kelas 3',
                'description'=> ('Aset kelas 3 adalah seluruh aset yang memiliki nilai diatas Rp. 10.000.000')
            ]
        ]);
    }
}