<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions
class TrainingAttended extends Model
{
    use HasFactory;

    protected $table = 'trainings_attended'; // This should match your migration

    protected $fillable = [
        'report_id',
        'title',
        'date_of_attendance',
        'status',
        'updated_by'
    ];

    public function report()
    {
        return $this->belongsTo(PerformanceObservationReport::class);
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
 
         Log::create([
             'model' => 'TrainingAttended',
             'record_id' => $model->id,
             'action' => $action,
             'changes' => json_encode($model->getAttributes()),
             'updated_by' => $fullName,
             'user_role' => $userRole,
             'client_full_name' => null, // Assuming no direct client relationship
         ]);
     }
}