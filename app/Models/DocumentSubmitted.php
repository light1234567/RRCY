<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log;     // Import Log facade

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



