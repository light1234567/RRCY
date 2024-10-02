<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crime extends Model
{
    use HasFactory;

    // Define the table name (optional if Laravel convention is followed)
    protected $table = 'crimes';

    // Define fillable attributes if needed
    protected $fillable = ['crime_name', 'category_id'];

    /**
     * A crime belongs to a crime category
     */
    public function category()
    {
        return $this->belongsTo(CrimeCategory::class, 'category_id');
    }
}
