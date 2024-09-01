<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_needs_assessment_id', 'education_level', 'year_or_grade'
    ];

    public function trainingNeedsAssessment()
    {
        return $this->belongsTo(TrainingNeedsAssessment::class);
    }
}
