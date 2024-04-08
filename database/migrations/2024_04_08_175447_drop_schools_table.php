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
        Schema::dropIfExists('schools');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->unsignedBigInteger('headmaster_id')->nullable();
            $table->unsignedBigInteger('curriculum_deputy_id')->nullable();
            $table->unsignedBigInteger('student_affairs_deputy_id')->nullable();
            $table->unsignedBigInteger('committee_chairperson_id')->nullable();

            $table->foreign('headmaster_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('curriculum_deputy_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('student_affairs_deputy_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('committee_chairperson_id')->references('id')->on('employees')->onDelete('set null');

            $table->timestamps();
        });
    }
};
