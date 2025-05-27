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
        Schema::create('tax_brackets', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_income', 15, 2); // Thu nhập chịu thuế tối thiểu của bậc
            $table->decimal('max_income', 15, 2)->nullable(); // Thu nhập chịu thuế tối đa của bậc (có thể là NULL cho bậc cuối cùng)
            $table->decimal('tax_rate', 5, 2); // Thuế suất (ví dụ: 0.05 cho 5%)
            $table->integer('order')->unique(); // Thứ tự của bậc thuế (để đảm bảo thứ tự khi tính toán)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_brackets');
    }
};