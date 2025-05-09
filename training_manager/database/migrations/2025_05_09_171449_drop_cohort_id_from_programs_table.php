<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCohortIdFromProgramsTable extends Migration
{
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            // Xóa khóa ngoại trước tiên
            $table->dropForeign(['cohort_id']);
            // Sau đó, xóa cột cohort_id
            $table->dropColumn('cohort_id');
        });
    }

    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            // Trong hàm down, bạn cần thêm cột và sau đó tạo lại khóa ngoại
            $table->unsignedBigInteger('cohort_id')->after('id');
            $table->foreign('cohort_id')->references('id')->on('cohorts')->onDelete('cascade');
        });
    }
}
