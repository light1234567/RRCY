<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CiclSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'drn',
        'session',
        'title',
        'date_conducted',
        'objective',
        'methodology',
        'highlight',
        'outcome',
        'noted_by',
        'approved_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
