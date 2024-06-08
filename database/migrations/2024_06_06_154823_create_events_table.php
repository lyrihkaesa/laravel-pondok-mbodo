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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calendar_id')->constrained()->onDelete('cascade');
            $table->string('google_event_id')->nullable();
            $table->string('title'); // Google Calendar field is: summary
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_all_day')->default(false);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
