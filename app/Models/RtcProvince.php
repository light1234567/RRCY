<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtcProvince extends Model
{
    use HasFactory;

    // Define the table name (optional if Laravel convention is followed)
    protected $table = 'rtc_provinces';

    // Define fillable attributes if needed
    protected $fillable = ['province_name'];

    /**
     * A province has many RTC branches
     */
    public function branches()
    {
        return $this->hasMany(RtcBranch::class, 'province_id');
    }
}
