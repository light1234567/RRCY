<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

class PerformanceObservationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'assessment_date',
        'trainings_attended',
        'general_remarks',
        'prepared_by',
        'noted_by',
        'updated_by'
    ];

    public function indicators()
    {
        return $this->hasMany(PerformanceIndicator::class, 'report_id');
    }

    public function sections()
    {
        return $this->hasMany(PerformanceSection::class, 'report_id');
    }

    public function trainings()
    {
        return $this->hasMany(TrainingAttended::class, 'report_id');
    }

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
