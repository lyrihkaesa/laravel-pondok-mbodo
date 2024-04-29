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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('profile_picture_1x1')->nullable();
            $table->string('profile_picture_3x4')->nullable();
            $table->string('profile_picture_4x6')->nullable();
            $table->string('niy')->unique()->nullable(); // Nomor Induk Siswa atau Nomor Induk Yayasan
            $table->enum('gender', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->enum('religion', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'])->default('Islam');
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('province')->nullable();
            $table->string('regency')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->string('address')->nullable(); // Dusun
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('full_address')->nullable();
            $table->string('current_name_school')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('family_card')->nullable();
            $table->string('family_card_number')->nullable();
            $table->string('skhun')->nullable();
            $table->string('ijazah')->nullable();
            $table->date('start_employment_date')->nullable(); // Tanggal Mulai Bekerja
            $table->integer('salary')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
