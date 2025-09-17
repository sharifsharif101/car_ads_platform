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
        Schema::table('categories', function (Blueprint $table) {
            // نضيف عمود parent_id ليكون هو المفتاح الأجنبي
            // نجعله nullable لأن التصنيفات الرئيسية لن يكون لها أب
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // لحذف العمود والمفتاح الأجنبي عند التراجع عن الـ migration
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};