<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'client_id'];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}