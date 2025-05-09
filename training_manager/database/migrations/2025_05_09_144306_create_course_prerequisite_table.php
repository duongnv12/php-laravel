<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursePrerequisiteTable extends Migration
{
    public function up()
    {
        Schema::create('course_prerequisite', function (Blueprint $table) {
            $table->id();
            // course_id: Môn học hiện tại
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            // prerequisite_id: Môn học tiên quyết
            $table->foreignId('prerequisite_id')->constrained('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_prerequisite');
    }
}
