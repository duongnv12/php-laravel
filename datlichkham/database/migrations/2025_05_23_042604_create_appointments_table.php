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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade'); // Khóa ngoại liên kết với bảng users (là bệnh nhân)
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng doctors
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng schedules
            $table->date('appointment_date'); // Ngày của cuộc hẹn
            $table->time('appointment_time'); // Thời gian của cuộc hẹn
            $table->text('reason')->nullable(); // Lý do khám bệnh, có thể null
            $table->string('status')->default('pending'); // Trạng thái: 'pending', 'confirmed', 'completed', 'cancelled'
            $table->timestamps();

            // Đảm bảo mỗi khung giờ chỉ có thể được đặt một lần
            $table->unique('schedule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};