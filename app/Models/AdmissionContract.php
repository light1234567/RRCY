<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'client_id',
        'signed_date',
        'parent_custodian_signature',
        'lgu_worker_name',
        'rrcy_officer',
        'houseparent_on_duty',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
