<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'drn',
        'incident',
        'date_of_incident',
        'time_of_incident',
        'involved',
        'location',
        'action_taken',
        'agreements',
        'corrective_measure',
        'prepared_by',
        'reviewed_by',
        'approved_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
