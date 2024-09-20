<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions
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
   
    // Boot method to handle logging and updating fields
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            self::handleLogging($model, 'created');
        });

        static::updated(function ($model) {
            self::handleLogging($model, 'updated');
        });
    }

    protected static function handleLogging($model, $action)
    {
        Logger::info('Session Data', Session::all());

        $userFname = Session::get('user_fname');
        $userLname = Session::get('user_lname');
        $userRole = Session::get('user_role');

        if (!$userFname || !$userLname || !$userRole) {
            Logger::warning('User details not found in session during ' . $action);
            return;
        }

        $fullName = trim($userFname . ' ' . $userLname);
        $model->load('client');

        $client = $model->client;
        $clientFullName = '';
        if ($client) {
            $clientFullName = trim(
                $client->first_name . ' ' .
                ($client->middle_name ? $client->middle_name . ' ' : '') .
                $client->last_name .
                ($client->suffix ? ', ' . $client->suffix : '')
            );
        }

        Log::create([
            'model' => 'RrcyForm',
            'record_id' => $model->client_id . '-' . $model->form, // Log composite key
            'action' => $action,
            'changes' => json_encode($model->getAttributes()),
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => $clientFullName,
        ]);
    }
}