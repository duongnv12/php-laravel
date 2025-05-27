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
        Schema::create('dependents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_payer_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với tax_payers
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->string('relationship'); // Ví dụ: 'child', 'parent', 'spouse'
            $table->string('identification_number')->nullable()->unique(); // CMND/CCCD (có thể null, duy nhất)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependents');
    }
};