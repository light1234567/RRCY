<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'monthly_inventory_id',
        'name',
        'description',
        'qty',
        'brand',
        'size',
        'color',
        'old',
        'new',
        'remarks',
        'updated_by'
    ];

    public function inventory()
    {
        return $this->belongsTo(MonthlyInventory::class);
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
     * @param  \App\Models\InventoryItem  $model
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

        Logger::info('InventoryItem ' . ucfirst($action), [
            'updated_by' => $fullName,
            'user_role' => $userRole,
        ]);

        // Log the action in the logs table
        Log::create([
            'model' => 'InventoryItem',
            'record_id' => $model->id,
            'action' => $action,
            'changes' => json_encode($model->getAttributes()), // Log the model's attributes
            'updated_by' => $fullName,
            'user_role' => $userRole,
            'client_full_name' => null, // Assuming no client involved here
        ]);
    }
}