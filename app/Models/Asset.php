<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function person_in_charge()
    {
        return $this->belongsTo(PersonInCharge::class, 'pic_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function unit_of_measurement()
    {
        return $this->belongsTo(UnitOfMeasurement::class);
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }
    
    public function mutations()
    {
        return $this->belongsToMany(Mutation::class, 'asset_mutation');
    }

    public function disposals()
    {
        return $this->belongsToMany(Disposal::class, 'asset_disposal');
    }
}