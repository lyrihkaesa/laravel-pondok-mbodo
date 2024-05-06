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
        Schema::create('wallets', function (Blueprint $table) {
            $table->string('id')->primary(); // Menggunakan string sebagai primary key
            $table->string('name');
            $table->decimal('balance', 20, 2)->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->json('policy')->nullable();
            $table->softDeletes(); // Mengaktifkan soft delete
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->index(['user_id', 'organization_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
