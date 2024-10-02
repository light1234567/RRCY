<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrimeCategory extends Model
{
    use HasFactory;

    // Define the table name (optional if Laravel convention is followed)
    protected $table = 'crime_categories';

    // Define fillable attributes if needed
    protected $fillable = ['category_name'];

    /**
     * A crime category has many crimes
     */
    public function crimes()
    {
        return $this->hasMany(Crime::class, 'category_id');
    }
}
