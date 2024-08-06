<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    public $incrementing = false; // Disable auto-incrementing ID

    protected $primaryKey = ['client_id', 'document']; // Define composite key
    protected $keyType = 'string'; // Set key type if necessary

    protected $fillable = [
        'client_id',
        'document',
        'yes',
        'no',
        'remarks',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
