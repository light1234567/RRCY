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
        'sex',
        'date_of_birth',
        'place_of_birth',
        'province',
        'city',
        'barangay',
        'street',
        'religion',
        'Status'
    ];

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
