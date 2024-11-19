<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutationFile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'mutation_id',
        'file_name',
    ];
}
