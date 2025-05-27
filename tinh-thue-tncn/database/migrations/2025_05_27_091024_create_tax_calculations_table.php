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
        Schema::create('tax_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liên kết với bảng users
            $table->decimal('total_income', 15, 2);
            $table->decimal('social_insurance_contribution', 15, 2);
            $table->integer('number_of_dependents');
            $table->decimal('charitable_contributions', 15, 2)->default(0);
            $table->decimal('retirement_fund_contributions', 15, 2)->default(0); // Giá trị người dùng nhập
            $table->decimal('calculated_retirement_fund_deduction', 15, 2)->default(0); // Giá trị thực tế được giảm trừ (sau khi áp trần)
            $table->decimal('personal_deduction_amount', 15, 2);
            $table->decimal('dependent_deduction_amount', 15, 2);
            $table->decimal('total_deductions', 15, 2);
            $table->decimal('taxable_income', 15, 2);
            $table->decimal('final_tax_amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_calculations');
    }
};