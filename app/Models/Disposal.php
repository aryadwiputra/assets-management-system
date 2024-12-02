<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'asset_disposal');
    }
    
    public function files()
    {
        return $this->hasMany(DisposalFile::class);
    }

    public function pic()
    {
        return $this->belongsTo(PersonInCharge::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
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
