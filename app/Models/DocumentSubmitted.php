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

    // Automatically decode the JSON array when retrieving the document_name
    public function getDocumentNameAttribute($value)
    {
        return json_decode($value, true); // Convert JSON string to array
    }

    // Automatically encode the documents array to JSON when saving
    public function setDocumentNameAttribute($value)
    {
        $this->attributes['document_name'] = json_encode($value); // Convert array to JSON
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class, 'admission_id');
    }
}



