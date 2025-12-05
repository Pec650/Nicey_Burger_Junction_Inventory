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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('user');         // Who did it? (e.g., admin@gmail.com)
            $table->string('action');       // What did they do? (e.g., "Sold")
            $table->string('product_name'); // Which product?
            $table->string('description')->nullable(); // Details (e.g., "-1 Stock")
            $table->timestamps();           // When did it happen?
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
