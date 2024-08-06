<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

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
