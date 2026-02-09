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
        Schema::table('order_items', function (Blueprint $table) {
            // Add order_id if it doesn't exist
            if (!Schema::hasColumn('order_items', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable()->index();
            }
            // Add product_id if it doesn't exist
            if (!Schema::hasColumn('order_items', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable()->index();
            }
            // Add quantity if it doesn't exist
            if (!Schema::hasColumn('order_items', 'quantity')) {
                $table->integer('quantity')->default(1);
            }
            // Add price if it doesn't exist
            if (!Schema::hasColumn('order_items', 'price')) {
                $table->decimal('price', 10, 2)->default(0);
            }
            // Add total if it doesn't exist
            if (!Schema::hasColumn('order_items', 'total')) {
                $table->decimal('total', 10, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'order_id')) {
                $table->dropColumn('order_id');
            }
            if (Schema::hasColumn('order_items', 'product_id')) {
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('order_items', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('order_items', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('order_items', 'total')) {
                $table->dropColumn('total');
            }
        });
    }
};
