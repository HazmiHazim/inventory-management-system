<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'supplier_id',
        'purchase_price',
        'sale_price',
        'quantity_on_hand',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
