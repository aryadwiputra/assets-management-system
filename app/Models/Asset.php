<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function pic()
    {
        return $this->belongsTo(PersonInCharge::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function uom()
    {
        return $this->belongsTo(UnitOfMeasurement::class);
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }
    
    
}