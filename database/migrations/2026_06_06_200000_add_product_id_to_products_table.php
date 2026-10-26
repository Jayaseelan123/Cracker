<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds a unique, formatted product_id column (e.g. CKR-0001)
     * and backfills all existing products.
     */
    public function up(): void
    {
        // Add the column only if it doesn't already exist
        if (!Schema::hasColumn('products', 'product_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('product_id', 20)->nullable()->unique()->after('id');
            });
        }

        // Backfill existing products: CKR-{id zero-padded to 4 digits}
        DB::table('products')->orderBy('id')->each(function ($product) {
            DB::table('products')
                ->where('id', $product->id)
                ->whereNull('product_id')
                ->update([
                    'product_id' => 'CKR-' . str_pad($product->id, 4, '0', STR_PAD_LEFT),
                ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};
