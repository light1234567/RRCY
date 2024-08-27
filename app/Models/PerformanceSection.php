<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'title',
        'sub_total',
        'remarks',
    ];

    public function report()
    {
        return $this->belongsTo(PerformanceObservationReport::class);
    }

    public function indicators()
    {
        return $this->hasMany(PerformanceIndicator::class, 'section_id');
    }
}
