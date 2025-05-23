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
        Schema::create('specialties', function (Blueprint $table) {
            $table->id(); // Tự động tạo trường id (khóa chính, tự tăng)
            $table->string('name')->unique(); // Tên chuyên khoa, phải là duy nhất
            $table->text('description')->nullable(); // Mô tả chuyên khoa, có thể null
            $table->timestamps(); // Tự động tạo created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialties');
    }
};