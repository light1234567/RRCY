<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

class SecondIntakeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'general_intake_id',
        'date',
        'vices',
        'school_activities_achievement',
        'occupation_of_mother',
        'occupation_of_father',
        'siblings',
        'responsible_for_households_chores',
        'detention_days',
        'community',
        'house_made_of',
        'updated_by'
    ];

    protected $casts = [
        'vices' => 'array',
        'siblings' => 'array',
        'community' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function generalIntakeSheet()
    {
        return $this->belongsTo(GeneralIntakeSheet::class, 'general_intake_id');
    }
   // Automatically update the 'updated_by' field when the model is created or updated
   protected static function boot()
   {
       parent::boot();

       static::creating(function ($model) {
           // Log the entire session data for debugging
           Log::info('Session Data', Session::all());

           // Get the user's first name from the session
           $userFname = Session::get('user_fname');

           // Log the specific 'user_fname' from the session
           Log::info('Creating Admission', ['user_fname' => $userFname]);

           // Set the 'updated_by' field to the user's first name from the session
           if ($userFname) {
               $model->updated_by = $userFname;
           } else {
               Log::warning('User first name not found in session during creation');
           }
       });

       static::updating(function ($model) {
           // Log the entire session data for debugging
           Log::info('Session Data', Session::all());

           // Get the user's first name from the session
           $userFname = Session::get('user_fname');

           // Log the specific 'user_fname' from the session
           Log::info('Updating Admission', ['user_fname' => $userFname]);

           // Set the 'updated_by' field to the user's first name from the session
           if ($userFname) {
               $model->updated_by = $userFname;
           } else {
               Log::warning('User first name not found in session during update');
           }
       });
   }
}