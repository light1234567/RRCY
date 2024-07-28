<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'committing_court',
        'crim_case_number',
        'offense_committed',
        'date_admitted',
        'days_in_jail',
        'days_in_detention_center',
        'action_taken',
        'highest_educ_att',
        'school_name',
        'class_adviser',
        'client_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function distinguishingMarks()
    {
        return $this->hasOne(DistinguishingMark::class);
    }

    public function documents()
    {
        return $this->hasMany(DocumentSubmitted::class);
    }
}
