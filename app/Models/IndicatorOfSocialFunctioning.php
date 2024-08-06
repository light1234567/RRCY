<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicatorsOfSocialFunctioning extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date_admission',
        'date_administered',
        'physical_raw_score1',
        'physical_score_per_area1',
        'physical_raw_score2',
        'physical_score_per_area2',
        'emotional_raw_score1',
        'emotional_score_per_area1',
        'emotional_raw_score2',
        'emotional_score_per_area2',
        'emotional_raw_score3',
        'emotional_score_per_area3',
        'emotional_raw_score4',
        'emotional_score_per_area4',
        'emotional_raw_score5',
        'emotional_score_per_area5',
        'emotional_raw_score6',
        'emotional_score_per_area6',
        'social_raw_score1',
        'social_score_per_area1',
        'social_raw_score2',
        'social_score_per_area2',
        'social_raw_score3',
        'social_score_per_area3',
        'social_raw_score4',
        'social_score_per_area4',
        'social_raw_score5',
        'social_score_per_area5',
        'social_raw_score6',
        'social_score_per_area6',
        'social_raw_score7',
        'social_score_per_area7',
        'social_raw_score8',
        'social_score_per_area8',
        'spiritual_raw_score1',
        'spiritual_score_per_area1',
        'educational_raw_score',
        'educational_score_per_area',
        'economic_raw_score',
        'economic_score_per_area',
        'general_score',
        'interpretation',
        'prepared_by',
        'discussed_with',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
