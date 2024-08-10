<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitialPsychologicalAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'admission_id',
        'nickname',
        'reason_for_referral',
        'family_history',
        'sexual_development',
        'medical_history',
        'school_history',
        'social_history',
        'personal_characteristics',
        'review_systems',
        'mental_status',
        'assessment_interview',
        'test_result',
        'clinical_impression',
        'plan_of_action',
        'prepared_by',
        'noted_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
