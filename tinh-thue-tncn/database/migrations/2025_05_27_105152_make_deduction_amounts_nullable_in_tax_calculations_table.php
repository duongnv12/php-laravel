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
        Schema::table('tax_calculations', function (Blueprint $table) {
            $table->decimal('personal_deduction_amount', 15, 2)->nullable()->change();
            $table->decimal('dependent_deduction_amount', 15, 2)->nullable()->change();
            $table->decimal('calculated_retirement_fund_deduction', 15, 2)->nullable()->change();
            // Làm tương tự cho các cột liên quan khác nếu bạn thấy cần thiết
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_calculations', function (Blueprint $table) {
            // Đảo ngược lại nếu cần (mặc định là NOT NULL nếu không có ->nullable())
            $table->decimal('personal_deduction_amount', 15, 2)->nullable(false)->change();
            $table->decimal('dependent_deduction_amount', 15, 2)->nullable(false)->change();
            $table->decimal('calculated_retirement_fund_deduction', 15, 2)->nullable(false)->change();
        });
    }
};