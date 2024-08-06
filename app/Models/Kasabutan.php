<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasabutan extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'client_resident',
        'parent_guardian',
        'case_manager',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
