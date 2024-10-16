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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();

            // General
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();

            // Vision and Mission
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();

            // Contact
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // The Number
            $table->string('npsn')->nullable(); // Nomor Pokok Sekolah Nasional
            $table->string('nsm')->nullable(); // Nomor Statistik Madarasah

            // Dynamic Content
            $table->jsonb('content')->nullable();

            // created_at and updated_at and deleted_at
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
