<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSubmitted extends Model
{
    use HasFactory;

    protected $table = 'documents_submitted';

    protected $fillable = [
        'scsr', 'courtOrder', 'medicalCertificates', 'consConsent', 
        'schoolRecords', 'others', 'admission_id', 'client_id'
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}



