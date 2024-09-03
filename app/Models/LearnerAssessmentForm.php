<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnerAssessmentForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'school_year',
        'grading_period',
        'grade',
        'date',
        'recommendations',
        'prepared_by',
        'noted_by',
    ];

    public function readingAssessments()
    {
        return $this->hasOne(ReadingAssessment::class);
    }

    public function writingAssessments()
    {
        return $this->hasOne(WritingAssessment::class);
    }

    public function numeracyAssessments()
    {
        return $this->hasOne(NumeracyAssessment::class);
    }

    public function groupWorkAssessments()
    {
        return $this->hasOne(GroupWorkAssessment::class);
    }
}
