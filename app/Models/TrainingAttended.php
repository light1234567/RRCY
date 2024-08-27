<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingAttended extends Model
{
    use HasFactory;

    protected $table = 'trainings_attended'; // This should match your migration

    protected $fillable = [
        'report_id',
        'title',
        'date_of_attendance',
        'status',
    ];

    public function report()
    {
        return $this->belongsTo(PerformanceObservationReport::class);
    }
}

