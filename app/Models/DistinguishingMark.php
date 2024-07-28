<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistinguishingMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'tattoo_scars', 'height', 'weight', 'colour_of_eye', 'skin', 'admission_id', 'client_id'
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}

