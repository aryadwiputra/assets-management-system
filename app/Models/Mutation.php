<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fromEmployee()
    {
        return $this->belongsTo(Employee::class, 'from_employee');
    }

    public function toEmployee()
    {
        return $this->belongsTo(Employee::class, 'to_employee');
    }

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location');
    }

    public function fromPic()
    {
        return $this->belongsTo(PersonInCharge::class, 'from_pic');
    }

    public function toPic()
    {
        return $this->belongsTo(PersonInCharge::class, 'to_pic');
    }
}
