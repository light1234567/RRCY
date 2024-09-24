<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SHP extends Model
{
    use HasFactory;

    // Explicitly specify the table name
    protected $table = 'shps';

    protected $fillable = [
        'client_id',
        'name',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
