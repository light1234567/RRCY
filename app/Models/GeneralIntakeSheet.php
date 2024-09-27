<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions

class GeneralIntakeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'occupation',
        'highest_educ_att',
        'school_name',
        'class_adviser',
        'problem_presented',
        'brief_physical_description',
        'major_life_event',
        'enduring_life_strain',
        'life_transition',
        'development_changes',
        'normalization',
        'behaviour_towards_incident',
        'attachments',
        'skills',
        'resources',
        'earnings_income',
        'source_of_income_in_street',
        'hrs_stay_in_street',
        'length_stay_in_street',
        'common_substance_used',
        'initial_assessment',
        'recommendations',
        'prepared_by',
        'first_intake_case_manager',
        'reviewed_by',
        'updated_by'
    ];

    protected $casts = [
        'major_life_event' => 'array',
        'enduring_life_strain' => 'array',
        'life_transition' => 'array',
        'development_changes' => 'array',
        'normalization' => 'array',
        'behaviour_towards_incident' => 'array',
        'attachments' => 'array',
        'skills' => 'array',
        'resources' => 'array',
        'source_of_income_in_street' => 'array',
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

    /**
     * Handle logging for created and updated events
     * 
     * @param  \App\Models\GeneralIntakeSheet  $model
     * @param  string  $action
     * @return void
     */
    protected static function handleLogging($model, $action)
    {
        // Log the session data for debugging
        Logger::info('Session Data', Session::all());

        // Fetch the user's first name, last name, and role from the session
        $userFname = Session::get('user_fname');
        $userLname = Session::get('user_lname');
        $userRole = Session::get('user_role');

        if (!$userFname || !$userLname || !$userRole) {
            Logger::warning('User details not found in session during ' . $action);
            return;
        }

        // Concatenate the first name and last name to create the full name
        $fullName = trim($userFname . ' ' . $userLname);

        // Ensure the client relationship is loaded
        $model->load('client');

        // Fetch the client details and concatenate to form the full name
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

        Logger::info('GeneralIntakeSheet ' . ucfirst($action), [
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => $clientFullName,
        ]);

        // Get the current model attributes and filter out unnecessary fields
        $currentAttributes = collect($model->getAttributes())->except([
            'id', 'client_id', 'created_at', 'updated_at', 'updated_by'
        ]);

        // Handle logging for 'created' action (only show new values)
        if ($action === 'created') {
            Log::create([
                'model' => 'GeneralIntakeSheet',
                'record_id' => $model->id,
                'action' => $action,
                'changes' => json_encode($currentAttributes), // Log only necessary values
                'updated_by' => $fullName,
                'user_role' => $userRole,
                'client_full_name' => $clientFullName,
            ]);
        }

        // Handle logging for 'updated' action (show old and new values)
        if ($action === 'updated') {
            // Get the original attributes of the model before updating
            $original = $model->getOriginal();

            // Get the changes that were made (only dirty fields)
            $changes = collect($model->getDirty())->mapWithKeys(function ($value, $key) use ($original) {
                return [$key => ['old' => $original[$key] ?? null, 'new' => $value]];
            })->except([
                'id', 'client_id', 'created_at', 'updated_at', 'updated_by'
            ]); // Exclude unnecessary fields from changes

            Log::create([
                'model' => 'GeneralIntakeSheet',
                'record_id' => $model->id,
                'action' => $action,
                'changes' => json_encode($changes), // Log only necessary changes
                'updated_by' => $fullName,
                'user_role' => $userRole,
                'client_full_name' => $clientFullName,
            ]);
        }
    }
}
