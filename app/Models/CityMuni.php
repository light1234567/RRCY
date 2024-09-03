<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityMuni extends Model
{
    use HasFactory;

    protected $table = 'tbl_citymuni'; // Specify table name

    public function province()
    {
        return $this->belongsTo(Province::class, 'psgc', 'psgc');
    }

    public function barangays()
    {
        return $this->hasMany(Brgy::class, 'psgc', 'psgc');
    }
}
