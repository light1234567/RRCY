<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talambuhay extends Model
{
    use HasFactory;

    protected $table = 'talambuhays'; // Ensure this matches the table name in the migration

    protected $fillable = [
        'client_id',
        'about_my_family',
        'about_my_self',
        'about_my_case',
        'case_manager',
        'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
?>
