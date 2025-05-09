<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseProgramTable extends Migration
{
    public function up()
    {
        Schema::create('course_program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            // Một trường tùy chọn để lưu thứ tự, học kỳ, hoặc thông tin bổ sung khác nếu cần
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_program');
    }
}
