<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterventionPlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'objectives',
        'activities',
        'time_frame',
        'responsible_person',
        'expected_outcome',
        'remarks',
    ];

    public function plan()
    {
        return $this->belongsTo(InterventionPlan::class);
    }
}
