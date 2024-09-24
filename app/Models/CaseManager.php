<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}