<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposalFile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'disposal_file';
}
