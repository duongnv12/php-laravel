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
        Schema::create('tax_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Ví dụ: 'personal_deduction', 'dependent_deduction'
            $table->string('value');       // Giá trị của cài đặt
            $table->string('description')->nullable(); // Mô tả cài đặt
            $table->timestamps();
        });

        // Insert initial data (optional, but good for first run)
        // Đây là ví dụ, bạn có thể thêm các cài đặt khác nếu cần
        \App\Models\TaxSetting::create(['key' => 'personal_deduction', 'value' => '11000000', 'description' => 'Mức giảm trừ bản thân']);
        \App\Models\TaxSetting::create(['key' => 'dependent_deduction', 'value' => '4400000', 'description' => 'Mức giảm trừ người phụ thuộc']);
        \App\Models\TaxSetting::create(['key' => 'max_retirement_fund_deduction', 'value' => '1000000', 'description' => 'Mức tối đa giảm trừ quỹ hưu trí tự nguyện']);

        // Tạm thời bỏ qua việc lưu biểu thuế vào DB để đơn giản hóa.
        // Biểu thuế thường ít thay đổi, nếu có thì là cả cấu trúc, không phải từng số.
        // Nếu cần lưu biểu thuế động, bạn sẽ cần một bảng phức tạp hơn (ví dụ: 'tax_brackets').
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_settings');
    }
};