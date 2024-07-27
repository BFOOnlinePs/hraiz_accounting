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
        Schema::table('orders_sales', function (Blueprint $table) {
            $table->enum('order_status', ['invoice_has_been_posted','invoice_has_not_been_posted'])->default('invoice_has_not_been_posted')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_sales', function (Blueprint $table) {
            //
        });
    }
};
