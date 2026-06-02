<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terms_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_ta')->nullable();
            $table->longText('content_en');
            $table->longText('content_ta')->nullable();
            $table->string('section_type')->default('terms'); // terms | privacy
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terms_sections');
    }
};
