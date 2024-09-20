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
            'model' => 'PsychologicalInterventionPlanItem',
            'record_id' => $model->id,
            'action' => $action,
            'changes' => json_encode($model->getAttributes()),
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => null, // Assuming no direct client relationship
        ]);
    }
}
