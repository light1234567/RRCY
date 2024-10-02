<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RtcBranch extends Model
{
    use HasFactory;

    // Define the table name (optional if Laravel convention is followed)
    protected $table = 'rtc_branches';

    // Define fillable attributes if needed
    protected $fillable = ['branch_name', 'province_id'];

    /**
     * An RTC branch belongs to an RTC province
     */
    public function province()
    {
        return $this->belongsTo(RtcProvince::class, 'province_id');
    }
}
