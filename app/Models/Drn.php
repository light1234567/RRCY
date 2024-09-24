<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drn extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'drn',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
