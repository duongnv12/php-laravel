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
        Schema::create('tax_payers', function (Blueprint $table) {
            $table->id(); // Khóa chính tự tăng
            $table->string('full_name'); // Tên đầy đủ
            $table->string('tax_code')->nullable()->unique(); // Mã số thuế (có thể null, phải là duy nhất)
            $table->string('identification_number')->unique(); // CCCD/CMND (phải là duy nhất)
            $table->decimal('total_income', 15, 2); // Tổng thu nhập (15 chữ số, 2 số thập phân)
            $table->decimal('social_insurance_contribution', 15, 2)->default(0); // Khoản đóng BHXH (mặc định 0)
            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_payers');
    }
};