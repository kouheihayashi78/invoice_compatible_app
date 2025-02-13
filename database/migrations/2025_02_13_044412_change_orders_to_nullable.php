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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('order_product_id2')->nullable()->change();
            $table->integer('order_num2')->nullable()->change();
            $table->foreignId('order_product_id3')->nullable()->change();
            $table->integer('order_num3')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('order_product_id2')->nullable(false)->change();
            $table->integer('order_num2')->nullable(false)->change();
            $table->foreignId('order_product_id3')->nullable(false)->change();
            $table->integer('order_num3')->nullable(false)->change();
        });
    }
};
