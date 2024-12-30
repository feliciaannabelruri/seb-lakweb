<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddIndexesToTables extends Migration
{
    public function up()
    {
        // Cek dan tambahkan index untuk toppings
        if (Schema::hasTable('toppings')) {
            $indexes = DB::select("SHOW INDEXES FROM toppings");
            $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();
            
            Schema::table('toppings', function (Blueprint $table) use ($existingIndexes) {
                // Index untuk is_available jika belum ada
                if (!in_array('toppings_is_available_index', $existingIndexes)) {
                    $table->index('is_available');
                }
                // Index untuk kombinasi is_available dan stock jika belum ada
                if (!in_array('toppings_is_available_stock_index', $existingIndexes)) {
                    $table->index(['is_available', 'stock']);
                }
            });
        }

        // Cek dan tambahkan index untuk users
        if (Schema::hasTable('users')) {
            $indexes = DB::select("SHOW INDEXES FROM users");
            $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();
            
            Schema::table('users', function (Blueprint $table) use ($existingIndexes) {
                // Index untuk is_admin jika belum ada
                if (!in_array('users_is_admin_index', $existingIndexes)) {
                    $table->index('is_admin');
                }
            });
        }
    }

    public function down()
    {
        // Hapus index dari toppings
        if (Schema::hasTable('toppings')) {
            Schema::table('toppings', function (Blueprint $table) {
                try {
                    $table->dropIndex('toppings_is_available_index');
                } catch (\Exception $e) {
                    // Index mungkin sudah tidak ada
                }
                try {
                    $table->dropIndex('toppings_is_available_stock_index');
                } catch (\Exception $e) {
                    // Index mungkin sudah tidak ada
                }
            });
        }

        // Hapus index dari users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                try {
                    $table->dropIndex('users_is_admin_index');
                } catch (\Exception $e) {
                    // Index mungkin sudah tidak ada
                }
            });
        }
    }
}