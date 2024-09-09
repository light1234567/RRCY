<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'folder_id', 'client_id'];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}