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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->unsignedBiginteger('classroom_id')->unsigned();
            $table->unsignedBiginteger('student_id')->unsigned();
            $table->foreign('classroom_id')->on('classrooms')->references('id')->onDelete('cascade');
            $table->foreign('student_id')->on('students')->references('id')->onDelete('cascade');
            $table->primary(['classroom_id', 'student_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
