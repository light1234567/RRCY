<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'monthly_inventory_id',
        'name',
        'description',
        'qty',
        'brand',
        'size',
        'color',
        'old',
        'new',
        'remarks'
    ];

    public function inventory()
    {
        return $this->belongsTo(MonthlyInventory::class);
    }
}
