<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralIntakeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'occupation',
        'highest_educ_att',
        'school_name',
        'class_adviser',
        'problem_presented',
        'brief_physical_description',
        'major_life_event',
        'enduring_life_strain',
        'life_transition',
        'development_changes',
        'normalization',
        'behaviour_towards_incident',
        'attachments',
        'skills',
        'resources',
        'earnings_income',
        'source_of_income_in_street',
        'hrs_stay_in_street',
        'length_stay_in_street',
        'common_substance_used',
        'initial_assessment',
        'recommendations',
        'vices',
        'school_activities_achievement',
        'occupation_of_mother',
        'occupation_of_father',
        'siblings',
        'responsible_for_households_chores',
        'water_source',
        'house_made_of',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
