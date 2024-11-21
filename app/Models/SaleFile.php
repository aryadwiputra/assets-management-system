<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleFile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'sale_files';

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
