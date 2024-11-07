<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function location()
    {
        return $this->hasMany(Location::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}