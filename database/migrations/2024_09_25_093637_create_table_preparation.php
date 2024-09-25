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
        Schema::create('preparation', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('from_user');
            $table->integer('to_user');
            $table->enum('status',['waiting_prepared','ready_prepared','delivered']);
            $table->text('notes')->nullable();
            $table->text('notes_preparation')->nullable();
            $table->dateTime('insert_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preparation');
    }
};
