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
        if (! Schema::hasColumn('order_items', 'order_id')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->unsignedBigInteger('order_id')->nullable()->index();
                $table->unsignedBigInteger('product_id')->nullable()->index();
                $table->integer('quantity')->default(1);
                $table->decimal('price', 10, 2)->default(0);
                $table->decimal('total', 10, 2)->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'order_id')) {
                $table->dropColumn(['order_id','product_id','quantity','price','total']);
            }
        });
    }
};
