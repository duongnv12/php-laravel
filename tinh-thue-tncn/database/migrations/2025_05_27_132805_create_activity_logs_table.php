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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Người dùng thực hiện hành động
            $table->string('action'); // Hành động được thực hiện (e.g., 'created', 'updated', 'deleted', 'reset_password_link_sent')
            $table->string('model_type')->nullable(); // Model bị ảnh hưởng (e.g., 'App\Models\User', 'App\Models\TaxBracket')
            $table->unsignedBigInteger('model_id')->nullable(); // ID của bản ghi bị ảnh hưởng
            $table->json('old_data')->nullable(); // Dữ liệu cũ trước khi thay đổi (chỉ cho update)
            $table->json('new_data')->nullable(); // Dữ liệu mới sau khi thay đổi (cho create/update)
            $table->string('ip_address')->nullable(); // Địa chỉ IP của người dùng
            $table->text('user_agent')->nullable(); // User Agent của trình duyệt
            $table->timestamps();

            // Thêm index để tối ưu truy vấn
            $table->index(['user_id', 'model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};