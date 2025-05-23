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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng users
            $table->foreignId('specialty_id')->nullable()->constrained()->onDelete('set null'); // Khóa ngoại liên kết với bảng specialties, có thể null
            $table->string('phone')->nullable(); // Số điện thoại, có thể null
            $table->string('address')->nullable(); // Địa chỉ, có thể null
            $table->text('bio')->nullable(); // Tiểu sử/thông tin giới thiệu, có thể null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};