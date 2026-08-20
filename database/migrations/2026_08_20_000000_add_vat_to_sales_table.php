<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->after('total_amount')->nullable();
            $table->decimal('vat_rate', 5, 2)->after('subtotal')->default(0);
            $table->decimal('vat_amount', 10, 2)->after('vat_rate')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'vat_rate', 'vat_amount']);
        });
    }
};