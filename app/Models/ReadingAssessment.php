<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log as Logger;
use App\Models\Log;

class ReadingAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'learner_assessment_form_id',
        'pronunciation_remarks',
        'pronunciation',
        'fluency',
        'punctuation',
        'updated_by'
    ];

    public function learnerAssessmentForm()
    {
        return $this->belongsTo(LearnerAssessmentForm::class);
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
     * @param  \App\Models\ReadingAssessment  $model
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

        // Load the LearnerAssessmentForm and related Client details
        $model->load('learnerAssessmentForm.client');
        $learnerAssessmentForm = $model->learnerAssessmentForm;

        // Try to retrieve the client's full name directly from the LearnerAssessmentForm relationship
        $clientFullName = '';
        if ($learnerAssessmentForm && $learnerAssessmentForm->client) {
            $client = $learnerAssessmentForm->client;
            $clientFullName = trim(
                $client->first_name . ' ' .
                ($client->middle_name ? $client->middle_name . ' ' : '') .
                $client->last_name .
                ($client->suffix ? ', ' . $client->suffix : '')
            );
        }

        // Filter out unnecessary fields from the attributes
        $currentAttributes = collect($model->getAttributes())->except([
            'id', 'learner_assessment_form_id', 'created_at', 'updated_at', 'updated_by'
        ]);

        // Handle logging for 'created' action (only show new values)
        if ($action === 'created') {
            Log::create([
                'model' => 'ReadingAssessment',
                'record_id' => $model->id,
                'action' => $action,
                'changes' => json_encode($currentAttributes), // Log the filtered attributes
                'updated_by' => $fullName,
                'user_role' => $userRole,
                'client_full_name' => $clientFullName, // Populate with client full name if available
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
                'id', 'learner_assessment_form_id', 'created_at', 'updated_at', 'updated_by'
            ]); // Exclude unnecessary fields from changes

            Log::create([
                'model' => 'ReadingAssessment',
                'record_id' => $model->id,
                'action' => $action,
                'changes' => json_encode($changes), // Log only necessary changes
                'updated_by' => $fullName,
                'user_role' => $userRole,
                'client_full_name' => $clientFullName, // Populate with client full name if available
            ]);
        }
    }
}
