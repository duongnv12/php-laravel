<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');  // Ràng buộc với bảng students
            $table->foreignId('course_id')->constrained()->onDelete('cascade');   // Ràng buộc với bảng courses
            $table->enum('status', ['registered', 'completed', 'failed'])->default('registered');
            $table->decimal('grade', 5, 2)->nullable();  // Có thể lưu điểm số, cho phép null nếu chưa chấm
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
