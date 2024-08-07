<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondIntakeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'occupation',
        'highest_educ_att',
        'school_name',
        'class_adviser',
        'vices',
        'school_activities_achievement',
        'occupation_of_mother',
        'occupation_of_father',
        'siblings',
        'responsible_for_households_chores',
        'detention_days',
        'community',
        'house_made_of',
    ];

    protected $casts = [
        'vices' => 'array',
        'siblings' => 'array',
        'community' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
