<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'month',
        'drn',
        'resident_name',
        'houseparent_name'
    ];

    public function items()
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

