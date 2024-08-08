<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'signed_day',
        'signed_month',
        'parent_custodian_name',
        'lgu_worker_name',
        'rrcy_officer',
        'houseparent_on_duty',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
?>
