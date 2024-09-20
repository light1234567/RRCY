<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger;
use App\Models\Log;

class DistinguishingMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'tattoo_scars',
        'height',
        'weight',
        'colour_of_eye',
        'skin_colour',
        'admission_id',
        'updated_by'
        
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
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
 * @param  \App\Models\DistinguishingMark  $model
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

    // Log the action in the logs table
    Log::create([
        'model' => 'DistinguishingMark',
        'record_id' => $model->id,
        'action' => $action,
        'changes' => json_encode($model->getAttributes()), // Log the model's attributes
        'updated_by' => $fullName,
        'user_role' => $userRole,
        'client_full_name' => null, // Assuming no direct client name here, can be added if necessary
    ]);
}
}

