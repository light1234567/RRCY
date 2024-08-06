<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterventionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'period',
        'date_prepared',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InterventionPlanItem::class, 'plan_id');
    }
}
