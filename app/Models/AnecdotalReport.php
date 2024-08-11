<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnecdotalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'drn',
        'color',
        'physical',
        'emotional',
        'behavioral',
        'spiritual',
        'recommendation',
        'noted_by',
        'approved_by',
        'prepared_by',
        'house_parents',
        'house_parents_signature',
        'residents',
        'residents_signature',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
