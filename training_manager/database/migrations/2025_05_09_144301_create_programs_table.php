<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            // Liên kết với niên khóa
            $table->foreignId('cohort_id')->constrained('cohorts')->onDelete('cascade');
            $table->string('name');        // Ví dụ: "Chương trình đào tạo Khoa học Máy tính"
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
