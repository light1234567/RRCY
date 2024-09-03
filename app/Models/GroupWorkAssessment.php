<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupWorkAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_assessment_form_id',
        'participation',
        'participation_remarks',
        'focus',
        'focus_remarks',
        'help',
        'help_remarks',
        'questions',
        'questions_remarks',
        'ideas',
        'ideas_remarks',
        'feedback',
        'feedback_remarks',
    ];

    protected $casts = [
        'participation' => 'array',
        'focus' => 'array',
        'help' => 'array',
        'questions' => 'array',
        'ideas' => 'array',
        'feedback' => 'array',
    ];

    public function learnerAssessmentForm()
    {
        return $this->belongsTo(LearnerAssessmentForm::class);
    }
}
