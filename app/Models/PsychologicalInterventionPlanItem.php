<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions

class PsychologicalInterventionPlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'objectives',
        'activities',
        'responsible_person',
        'time_frame',
        'expected_output',
        'progress',
        'updated_by'
    ];

    public function plan()
    {
        return $this->belongsTo(PsychologicalInterventionPlan::class, 'plan_id');
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
     * @param  \App\Models\PsychologicalInterventionPlanItem  $model
     * @param  string  $action
     * @return void
     */
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

        // Load the related plan and client
        $model->load('plan.client');

        // Fetch the client details and concatenate to form the full name
        $client = $model->plan->client ?? null;
        $clientFullName = '';
        if ($client) {
            $clientFullName = trim(
                $client->first_name . ' ' .
                ($client->middle_name ? $client->middle_name . ' ' : '') .
                $client->last_name .
                ($client->suffix ? ', ' . $client->suffix : '')
            );
        }

        Logger::info('PsychologicalInterventionPlanItem ' . ucfirst($action), [
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => $clientFullName,
        ]);

        // Get the current model attributes and filter out unnecessary fields
        $currentAttributes = collect($model->getAttributes())->except([
            'id', 'created_at', 'updated_at', 'updated_by'
        ]);

        // Handle logging for 'created' action (only show new values)
        if ($action === 'created') {
            Log::create([
                'model' => 'PsychologicalInterventionPlanItem',
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
                'id', 'created_at', 'updated_at', 'updated_by'
            ]); // Exclude unnecessary fields from changes

            Log::create([
                'model' => 'PsychologicalInterventionPlanItem',
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
