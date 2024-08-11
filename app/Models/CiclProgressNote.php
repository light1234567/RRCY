<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CiclProgressNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'admission_id',
        'intervention_period',
        'problem_behavior_log',
        'interventions_conducted',
        'progress_notes',
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
