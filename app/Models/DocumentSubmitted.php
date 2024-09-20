<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use Illuminate\Support\Facades\Session; // Import Session facade
use App\Models\Log; // Import Log model for saving actions

class DocumentSubmitted extends Model
{
    use HasFactory;

    protected $table = 'documents_submitted';

    protected $fillable = [
        'document_name',
        'submitted',
        'admission_id',
        'updated_by'
    ];

    // Automatically decode the JSON array when retrieving the document_name
    public function getDocumentNameAttribute($value)
    {
        return json_decode($value, true); // Convert JSON string to array
    }

    // Automatically encode the documents array to JSON when saving
    public function setDocumentNameAttribute($value)
    {
        $this->attributes['document_name'] = json_encode($value); // Convert array to JSON
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
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
     * @param  \App\Models\DocumentSubmitted  $model
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

        // Ensure the admission relationship is loaded
        $model->load('admission');

        // Fetch the admission details and get the related client full name (if necessary)
        $admission = $model->admission;
        $clientFullName = '';
        if ($admission && $admission->client) {
            $client = $admission->client;
            $clientFullName = trim(
                $client->first_name . ' ' .
                ($client->middle_name ? $client->middle_name . ' ' : '') . 
                $client->last_name . 
                ($client->suffix ? ', ' . $client->suffix : '')
            );
        }

        Logger::info('DocumentSubmitted ' . ucfirst($action), [
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => $clientFullName,
        ]);

        // Update the 'updated_by' and 'user_role' fields
        $model->updated_by = $fullName;

        // Get the current model attributes and filter out unnecessary fields
        $currentAttributes = collect($model->getAttributes())->except([
            'id', 'admission_id', 'created_at', 'updated_at', 'updated_by'
        ]);

        // Handle logging for 'created' action (only show new values)
        if ($action === 'created') {
            Log::create([
                'model' => 'DocumentSubmitted',
                'record_id' => $model->id,
                'action' => $action,
                'changes' => json_encode($currentAttributes), // Log the attributes
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
                'id', 'admission_id', 'created_at', 'updated_at', 'updated_by','submitted'
            ]); // Exclude unnecessary fields from changes

            Log::create([
                'model' => 'DocumentSubmitted',
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
