<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceObservationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'assessment_date',
        'trainings_attended',
        'general_remarks',
        'prepared_by',
        'noted_by',
    ];

    public function indicators()
    {
        return $this->hasMany(PerformanceIndicator::class, 'report_id');
    }

    public function sections()
    {
        return $this->hasMany(PerformanceSection::class, 'report_id');
    }

    public function trainings()
    {
        return $this->hasMany(TrainingAttended::class, 'report_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
