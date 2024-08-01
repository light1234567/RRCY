<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSubmitted extends Model
{
    use HasFactory;

    protected $table = 'documents_submitted';

    protected $fillable = [
        'document_name',
        'submitted',
        'admission_id'
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}




