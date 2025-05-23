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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng doctors
            $table->date('date'); // Ngày làm việc
            $table->time('start_time'); // Thời gian bắt đầu
            $table->time('end_time'); // Thời gian kết thúc
            $table->string('status')->default('available'); // Trạng thái: 'available', 'booked', 'unavailable'
            $table->timestamps();

            // Đảm bảo không có hai khung giờ trùng lặp cho cùng một bác sĩ vào cùng một ngày và thời gian
            $table->unique(['doctor_id', 'date', 'start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};