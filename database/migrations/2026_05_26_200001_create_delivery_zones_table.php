<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->string('state_name');
            $table->json('cities')->nullable();       // ["Chennai","Coimbatore"] or null = All cities
            $table->boolean('all_cities')->default(false);
            $table->decimal('min_order_amount', 10, 2)->default(0);
            $table->decimal('packing_charges', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_zones');
    }
};
