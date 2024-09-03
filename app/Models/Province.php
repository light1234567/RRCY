<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'tbl_province'; // Specify table name

    public function cityMunis()
    {
        return $this->hasMany(CityMuni::class, 'psgc', 'psgc');
    }
}
