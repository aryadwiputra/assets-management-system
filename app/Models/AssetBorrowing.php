<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetBorrowing extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function from_pic()
    {
        return $this->belongsTo(PersonInCharge::class, 'from_pic');
    }

    public function to_pic()
    {
        return $this->belongsTo(PersonInCharge::class, 'to_pic');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
