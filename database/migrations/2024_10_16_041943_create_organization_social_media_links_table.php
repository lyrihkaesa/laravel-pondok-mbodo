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
        Schema::create('organization_social_media_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('url')->nullable();
            $table->string('visibility')->default('public');
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_social_media_links');
    }
};
