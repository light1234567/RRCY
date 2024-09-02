<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearnerAcademicBehavioralForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'month',
        'school_year',
        'learner_name',
        'grade',
        'lrn',
        'status',
        'skills',
        'observation_feedback',
        'learner_signature',
        'category_adviser_signature',
        'educational_section_head_signature',
        'center_head_signature',
    ];

    protected $casts = [
        'skills' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

