<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brgy extends Model
{
    use HasFactory;

    protected $table = 'tbl_brgy'; // Specify table name

    public function cityMuni()
    {
        return $this->belongsTo(CityMuni::class, 'psgc', 'psgc');
    }
}
