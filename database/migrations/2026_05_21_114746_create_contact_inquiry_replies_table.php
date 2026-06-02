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
        Schema::create('contact_inquiry_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_inquiry_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->boolean('is_admin')->default(false); // true if admin replied, false if client replied
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_inquiry_replies');
    }
};
