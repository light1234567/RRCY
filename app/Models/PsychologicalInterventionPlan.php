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
        'objectives',
        'activities',
        'responsible_person',
        'time_frame',
        'expected_output',
        'progress',
        'prepared_by',
        'noted_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
