<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sex', 'address', 'date_of_birth', 'religion', 'occupation'
    ];

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
