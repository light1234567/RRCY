<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'admitting_officer', 'case_manager', 'documents', 'rrcy_forms'];

    // Cast JSON fields
    protected $casts = [
        'documents' => 'array',
        'rrcy_forms' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
