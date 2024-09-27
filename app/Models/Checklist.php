<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 
        'admitting_officer',
        'checklist_case_manager', 
        'documents', 
        'rrcy_forms',    
        'updated_by'
    ];

    // Cast JSON fields
    protected $casts = [
        'documents' => 'array',
        'rrcy_forms' => 'array',
    ];

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

    /**
     * Handle logging for created and updated events
     * 
     * @param  \App\Models\Checklist  $model
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

        // Fetch the client details and create the client's full name (if available)
        $clientFullName = '';
        $client = $model->client;
        if ($client) {
            $clientFullName = trim(
                $client->first_name . ' ' .
                ($client->middle_name ? $client->middle_name . ' ' : '') . 
                $client->last_name . 
                ($client->suffix ? ', ' . $client->suffix : '')
            );
        }

        Logger::info('Checklist ' . ucfirst($action), [
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => $clientFullName,
        ]);

        // Update the 'updated_by' field
        $model->updated_by = $fullName;

        // Get the current model attributes and filter out unnecessary fields
        $currentAttributes = collect($model->getAttributes())->except([
            'id', 'client_id', 'created_at', 'updated_at', 'updated_by'
        ]);

        // Handle logging for 'created' action (only show new values)
        if ($action === 'created') {
            Log::create([
                'model' => 'Checklist',
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
                'model' => 'Checklist',
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
