<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

class SwappingForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'drn',
        'date_of_filing',
        'requesting_party_name',
        'requesting_party_position',
        'date_of_duty',
        'time_of_duty',
        'sod_name',
        'sod_date_of_duty',
        'sod_position',
        'sod_shift_time',
        'purpose',
        'requested_by',
        'accepted_by',
        'noted_by',
        'approved_by',
        'updated_by'
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
