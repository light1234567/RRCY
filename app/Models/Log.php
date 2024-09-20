<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'model', 
        'record_id', 
        'action', 
        'changes', 
        'updated_by',
        'client_full_name',
        'user_role'
    ];
}
