<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session; // Import Session facade
use Illuminate\Support\Facades\Log as Logger; // Import Log facade for logging
use App\Models\Log; // Import Log model for saving actions
class RrcyForm extends Model
{
    use HasFactory;

    public $incrementing = false; // Disable auto-incrementing ID

    protected $primaryKey = ['client_id', 'form']; // Define composite key
    protected $keyType = 'string'; // Set key type if necessary

    protected $fillable = [
        'client_id',
        'form',
        'yes',
        'no',
        'remarks',
        'updated_by'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
   
}