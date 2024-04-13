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
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');
            $table->unsignedBigInteger('organization_id')->nullable()->after('combined_name');
            $table->foreign('organization_id')->references('id')->on('organizations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable()->after('combined_name');
            $table->foreign('school_id')->references('id')->on('schools')->nullOnDelete();
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
    }
};
