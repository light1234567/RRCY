<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',  // Assuming each indicator belongs to a section
        'description',
        'self_rating',
        'mdo_rating',
    ];

    public function section()
    {
        return $this->belongsTo(PerformanceSection::class, 'section_id');
    }
}
