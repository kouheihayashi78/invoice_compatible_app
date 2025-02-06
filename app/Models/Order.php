<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'order_customer_id',
        'order_product_id1',
        'order_num1',
        'order_product_id2',
        'order_num2',
        'order_product_id3',
        'order_num3',
        'order_day'
    ];

    public $timestamps = false; // 無効

    // 第二引数は子モデルの外部キー、第三引数は親モデルのキー
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'order_customer_id', 'customer_id');
    }

    public function product1()
    {
        return $this->belongsTo(Product::class, 'order_product_id1', 'product_id');
    }

    public function product2()
    {
        return $this->belongsTo(Product::class, 'order_product_id2', 'product_id');
    }

    public function product3()
    {
        return $this->belongsTo(Product::class, 'order_product_id3', 'product_id');
    }
}
