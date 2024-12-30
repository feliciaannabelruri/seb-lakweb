<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        if (!Schema::hasColumn('orders', 'payment_proof')) {
            $table->string('payment_proof')->nullable();
        }

        if (!Schema::hasColumn('orders', 'total_price')) {
            $table->decimal('total_price', 10, 2);
        }

        if (!Schema::hasColumn('orders', 'status')) {
            $table->enum('status', ['pending_payment', 'processing', 'completed']);
        }
    });
}


public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        if (Schema::hasColumn('orders', 'payment_proof')) {
            $table->dropColumn('payment_proof');
        }

        if (Schema::hasColumn('orders', 'total_price')) {
            $table->dropColumn('total_price');
        }

        if (Schema::hasColumn('orders', 'status')) {
            $table->dropColumn('status');
        }
    });
}

};