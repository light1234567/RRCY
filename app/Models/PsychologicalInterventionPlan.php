<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychologicalInterventionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'as_of_date',
        'progress_notes',
        'prepared_by',
        'noted_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(PsychologicalInterventionPlanItem::class, 'plan_id');
    }
}
