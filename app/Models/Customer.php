<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_customer_id', 'customer_id');
    }
}
