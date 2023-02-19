<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'customer_contact_info',
        'product_id',
        'quantity_ordered',
        'total_cost',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
