<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwappingForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'drn',
        'date_of_filing',
        'requesting_party_name',
        'requesting_party_position',
        'date_of_duty',
        'time_of_duty',
        'sod_name',
        'sod_date_of_duty',
        'sod_position',
        'sod_shift_time',
        'purpose',
        'requested_by',
        'accepted_by',
        'noted_by',
        'approved_by',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
