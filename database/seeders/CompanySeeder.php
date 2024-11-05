<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::insert([[
            'name'=>'Iconmedia',
            'slug'=>'iconmedia',
            'description'=>'Iconmedia adalah holding company yang berfokus pada IT',
            'set_prefix_asset'=>true,
            'prefix_asset'=>'ICN-ASSET-',
            'set_prefix_document_asset'=>true,
            'prefix_document_asset'=>'ICN-DOC-',
            'set_prefix_mutation_asset'=>true,
            'prefix_mutation_asset'=> 'ICN-MUT-',
            'set_prefix_disposal_asset'=> true,
            'prefix_disposal_asset'=> 'ICN-DSP-',
            'logo'=>null,
        ], [
            'name'=>'Citanusa',
            'slug'=>'citanusa',
            'description'=>'Citanusa adalah sub company dari Iconmedia',
            'set_prefix_asset'=>true,
            'prefix_asset'=>'CNS-ASSET-',
            'set_prefix_document_asset'=>true,
            'prefix_document_asset'=>'CNS-DOC-',
            'set_prefix_mutation_asset'=>true,
            'prefix_mutation_asset'=> 'CNS-MUT-',
            'set_prefix_disposal_asset'=> true,
            'prefix_disposal_asset'=> 'CNS-DSP-',
            'logo'=>null,
        ]]);
    }
}