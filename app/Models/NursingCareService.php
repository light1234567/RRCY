<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

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
        'profile_image',
        'updated_by'  // Add profile image to fillable
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            // Log the entire session data for debugging
            Log::info('Session Data', Session::all());

            // Get the user's first name from the session
            $userFname = Session::get('user_fname');

            // Log the specific 'user_fname' from the session
            Log::info('Updating Checklist', ['user_fname' => $userFname]);

            // Set the 'updated_by' field to the user's first name from the session
            if ($userFname) {
                $model->updated_by = $userFname;
            } else {
                Log::warning('User first name not found in session');
            }
        });
    }
}
