<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('order_customer_id')->constrained('customers', 'customer_id');
            $table->foreignId('order_product_id1')->constrained('products', 'product_id');
            $table->integer('order_num1');
            $table->foreignId('order_product_id2')->constrained('products', 'product_id');
            $table->integer('order_num2');
            $table->foreignId('order_product_id3')->constrained('products', 'product_id');
            $table->integer('order_num3');
            $table->datetime('order_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
