<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('toppings', function (Blueprint $table) {
        if (!Schema::hasColumn('toppings', 'stock')) {
            $table->integer('stock')->default(0);
        }
        if (!Schema::hasColumn('toppings', 'is_available')) {
            $table->boolean('is_available')->default(true);
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('toppings', function (Blueprint $table) {
            $table->dropColumn(['stock', 'is_available']);
        });
    }
};
