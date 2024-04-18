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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('nik')->unique();
            $table->string('profile_picture_1x1')->nullable();
            $table->string('profile_picture_3x4')->nullable();
            $table->string('profile_picture_4x6')->nullable();
            $table->string('nip')->unique(); // Nomor Induk Siswa atau Nomor Induk Pesantren
            $table->string('nisn')->unique()->nullable();
            $table->string('kip')->unique()->nullable();
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
            $table->string('postcode')->nullable();
            $table->string('full_address')->nullable();
            $table->enum('status', ['Mendaftar', 'Aktif', 'Lulus', 'Tidak Aktif'])->default('Mendaftar');
            $table->string('current_name_school')->nullable();
            $table->enum('current_school', ['PAUD/TK', 'MI', 'SMP', 'MA', 'Takhasus'])->nullable();
            $table->enum('category', ['Santri Reguler', 'Santri Ndalem', 'Santri Berprestasi'])->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('family_card')->nullable();
            $table->string('number_family_card')->nullable();
            $table->string('skhun')->nullable();
            $table->string('ijazah')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
