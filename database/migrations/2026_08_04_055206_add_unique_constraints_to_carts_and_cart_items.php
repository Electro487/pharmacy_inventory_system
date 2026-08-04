<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add unique constraint to carts table (one cart per customer)
        Schema::table('carts', function (Blueprint $table) {
            $table->unique('customer_id');
        });

        // Add unique constraint to cart_items (one item per medicine per cart)
        Schema::table('cart_items', function (Blueprint $table) {
            $table->unique(['cart_id', 'medicine_id']);
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropUnique('carts_customer_id_unique');
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique('cart_items_cart_id_medicine_id_unique');
        });
    }
};