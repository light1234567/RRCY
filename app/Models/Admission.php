<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_status',
        'committing_court',
        'crim_case_number',
        'offense_committed',
        'date_admitted',
        'days_in_jail',
        'days_in_detention_center',
        'action_taken',
        'general_impression',
        'client_id',
        'referring_party_name',
        'referring_party_signature',
        'admitting_officer',
        'designation_id_contact',
        'designation',
        'office_address',
        'date_time',
        'noted_by'

    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function distinguishingMarks()
    {
        return $this->hasMany(DistinguishingMark::class);
    }

    public function documents()
    {
        return $this->hasMany(DocumentSubmitted::class);
    }
}
