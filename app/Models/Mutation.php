<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_mutation');
    }
    
    public function files()
    {
        return $this->hasMany(MutationFile::class);
    }

    public function pic()
    {
        return $this->belongsTo(PersonInCharge::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'to_location');
    }

    public function user()
    {
        return $this->belongsTo(User::class);   
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
