<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'sex',
        'date_of_birth',
        'place_of_birth',
        'province',
        'city',
        'barangay',
        'street',
        'religion',
        'child_status'
    ];

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function indicators()
    {
        return $this->hasMany(IndicatorsOfSocialFunctioning::class);
    }
    
    public function monthlyInventories()
    {
        return $this->hasMany(MonthlyInventory::class);
    }
}