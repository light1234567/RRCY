<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursingCareService extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date_of_admission',
        'current_medical_status',
        'temperature',
        'pulse_rate',
        'respiratory_rate',
        'blood_pressure',
        'height_cm',
        'weight_kg',
        'bmi',
        'bmi_remarks',
        'eyes_status',
        'nails_status',
        'ears_status',
        'skin_status',
        'mouth_teeth_status',
        'hair_status',
        'services_given',
        'remarks',
        'prepared_by',
        'noted_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
