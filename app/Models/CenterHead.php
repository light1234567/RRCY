<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterHead extends Model
{
    // The table associated with the model.
    protected $table = 'center_head';

    // Disable timestamps if your table does not have `created_at` and `updated_at` columns.
    public $timestamps = false;

    // The attributes that are mass assignable.
    protected $fillable = ['name'];
}
