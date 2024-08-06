<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPrivacyConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_signature',
        'date',
        'guardian_signature',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
