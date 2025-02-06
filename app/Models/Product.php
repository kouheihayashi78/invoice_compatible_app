<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'product_code',
        'product_price',
        'product_tax',
    ];

    public function product1()
    {
        return $this->hasMany(Order::class, 'order_product_id1', 'product_id');
    }

    public function product2()
    {
        return $this->hasMany(Order::class, 'order_product_id2', 'product_id');
    }

    public function product3()
    {
        return $this->hasMany(Order::class, 'order_product_id3', 'product_id');
    }
}
