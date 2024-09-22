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
        Schema::create('preparing_the_order', function (Blueprint $table) {
            $table->id();
            $table->integer('form_user');
            $table->integer('to_user');
            $table->integer('insert_at');
            $table->integer('user_notes');
            $table->integer('preparing_notes');
            $table->enum('status',['sent_to_storekeeper','in_preparation','prepared','delivered']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preparing_the_order');
    }
};
