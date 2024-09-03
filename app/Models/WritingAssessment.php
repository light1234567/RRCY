<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WritingAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_assessment_form_id',
        'punctuation',
        'punctuation_remarks',
        'capitalization',
        'capitalization_remarks',
        'grammar',
        'grammar_remarks',
        'content_ideas',
        'content_ideas_remarks',
        'spelling',
        'spelling_remarks',
    ];

    protected $casts = [
        'punctuation' => 'array',
        'capitalization' => 'array',
        'grammar' => 'array',
        'content_ideas' => 'array',
        'spelling' => 'array',
    ];

    public function learnerAssessmentForm()
    {
        return $this->belongsTo(LearnerAssessmentForm::class);
    }
}
