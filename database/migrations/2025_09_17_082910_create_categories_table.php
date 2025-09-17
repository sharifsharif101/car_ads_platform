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
       Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // اسم التصنيف، مثل: "ماركة"
        $table->string('slug')->unique(); // معرف قصير قابل للاستخدام في URLs
        $table->enum('type', ['select', 'text', 'number'])->default('select'); // نوع الإدخال
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
