<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function asset()
    {
        return $this->hasMany(Asset::class);
    }

    public function mutations()
    {
        return $this->hasMany(Mutation::class);
    }
}