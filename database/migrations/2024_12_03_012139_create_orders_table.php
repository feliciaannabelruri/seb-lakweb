<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('spice_level');
            $table->enum('consistency', ['nyemek', 'kuah', 'kering']);
            $table->decimal('total_price', 10, 2);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'rejected'])
                  ->default('pending');
            $table->string('rejection_reason')->nullable(); // For when admin rejects an order
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};