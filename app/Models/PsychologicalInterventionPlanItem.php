<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychologicalInterventionPlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'objectives',
        'activities',
        'responsible_person',
        'time_frame',
        'expected_output',
        'progress',
    ];

    public function plan()
    {
        return $this->belongsTo(PsychologicalInterventionPlan::class, 'plan_id');
    }
}
