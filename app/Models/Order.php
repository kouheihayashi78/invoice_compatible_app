<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_product_id1',
        'order_num1',
        'order_product_id2',
        'order_num2',
        'order_product_id3',
        'order_num3',
        'order_day'
    ];

    public $timestamps = false; // 無効
}
