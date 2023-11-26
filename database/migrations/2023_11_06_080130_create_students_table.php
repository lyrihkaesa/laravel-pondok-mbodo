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
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('nis')->unique(); // Nomor Induk Siswa atau Nomor Induk Pesantren
            $table->enum('gender', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['Aktif', 'Lulus', 'Tidak Aktif'])->default('Aktif');
            $table->enum('current_school', ['PAUD', 'TK', 'SD', 'SMP', 'SMK'])->nullable();
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
