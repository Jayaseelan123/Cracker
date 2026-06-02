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
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            // Basic Info
            $table->string('company_name')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();          // stored path
            $table->string('contact_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            // Bank Details
            $table->string('bank_ac_no')->nullable();
            $table->string('bank_ac_name')->nullable();
            $table->string('bank_ac_type')->nullable();  // savings / current
            $table->string('bank_name')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_details');
    }
};
