<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_needs_assessment_id', 'title', 'duration', 'location_outside', 'location_inside'
    ];

    public function trainingNeedsAssessment()
    {
        return $this->belongsTo(TrainingNeedsAssessment::class);
    }
}
