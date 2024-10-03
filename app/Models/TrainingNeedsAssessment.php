<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log as Logger;
use App\Models\Log;

class TrainingNeedsAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 
        'social_worker', 
        'houseparent',
        'father', 
        'mother', 
        'address', 
        'center_duration',
        'period', 
        'date_of_admission', 
        'training_details',
        'training_sector_details',
        'education_details',
        'updated_by',
    ];

    protected $casts = [
        'training_details' => 'array',
        'training_sector_details' => 'array',
        'education_details' => 'array',
    ];

    // Define relationships if any
    public function client()
    {
        return $this->belongsTo(Client::class);
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
            'model' => 'TrainingNeedsAssessment',
            'record_id' => $model->id,
            'action' => $action,
            'changes' => json_encode($model->getAttributes()),
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => $clientFullName,
        ]);
    }
}
