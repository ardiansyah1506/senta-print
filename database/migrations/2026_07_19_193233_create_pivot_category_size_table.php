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
        Schema::create('pivot_category_size', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('m_categories')->cascadeOnDelete();
            $table->foreignId('size_id')->constrained('m_sizes')->cascadeOnDelete();
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_category_size');
    }
};
