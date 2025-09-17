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
    Schema::create('cars', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // صاحب الإعلان
        $table->string('title');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->integer('seats')->nullable();
        $table->string('main_image')->nullable();
        $table->enum('status', ['active', 'inactive', 'pending', 'expired'])->default('pending');
        $table->integer('views')->default(0);
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
