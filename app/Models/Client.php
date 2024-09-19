<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions

class Client extends Model
{
    use HasFactory;

    // Allow mass assignment for the specified fields
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'sex',
        'date_of_birth',
        'place_of_birth',
        'province',
        'city',
        'barangay',
        'street',
        'religion',
        'child_status',
        'updated_by',
        'user_role' // Adding user_role to be logged and saved
    ];

    // Define relationships
    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function indicators()
    {
        return $this->hasMany(IndicatorsOfSocialFunctioning::class);
    }

    public function monthlyInventories()
    {
        return $this->hasMany(MonthlyInventory::class);
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
     * @param  \App\Models\Client  $model
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

        // Concatenate the client's full name (first name, middle name, last name, and suffix)
        $clientFullName = trim(
            $model->first_name . ' ' .
            ($model->middle_name ? $model->middle_name . ' ' : '') .
            $model->last_name .
            ($model->suffix ? ', ' . $model->suffix : '')
        );

        Logger::info('Client ' . ucfirst($action), [
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => $clientFullName,
        ]);

        // Update the 'updated_by' and 'user_role' fields
        $model->updated_by = $fullName;
        $model->user_role = $userRole;

        // Get the current model attributes and filter out unnecessary fields
        $currentAttributes = collect($model->getAttributes())->except([
            'id', 'created_at', 'updated_at', 'updated_by', 'user_role'
        ]);

        // Handle logging for 'created' action (only show new values)
        if ($action === 'created') {
            // Log the action in the logs table without unnecessary fields
            Log::create([
                'model' => 'Client',
                'record_id' => $model->id,
                'action' => $action,
                'changes' => json_encode($currentAttributes), // Only log necessary values
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
                'id', 'created_at', 'updated_at', 'updated_by', 'user_role'
            ]); // Exclude unnecessary fields from changes

            // Log the action in the logs table with old and new values
            Log::create([
                'model' => 'Client',
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
