<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSectorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_needs_assessment_id', 'sector', 'name', 'rank', 'remarks'
    ];

    public function trainingNeedsAssessment()
    {
        return $this->belongsTo(TrainingNeedsAssessment::class);
    }
}

class TrainingNeedsAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'birthplace', 'social_worker', 'houseparent',
        'father', 'mother', 'address', 'center_duration',
        'for_the', 'date_of_admission'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function educationDetails()
    {
        return $this->hasMany(EducationDetail::class);
    }

    public function trainingDetails()
    {
        return $this->hasMany(TrainingDetail::class);
    }

    public function trainingSectorDetails()
    {
        return $this->hasMany(TrainingSectorDetail::class);
    }
}
