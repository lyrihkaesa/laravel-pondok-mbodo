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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('type');
            $table->decimal('amount', 20, 2);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('from_wallet_id')->nullable();
            $table->unsignedBigInteger('to_wallet_id')->nullable();
            $table->unsignedBigInteger('student_bill_id')->nullable();
            $table->unsignedBigInteger('validated_by')->nullable();
            $table->datetime('transaction_at')->nullable();
            $table->json('image_attachments')->nullable();
            $table->json('file_attachments')->nullable();
            $table->timestamps();

            $table->foreign('from_wallet_id')->references('id')->on('wallets')->onDelete('set null');
            $table->foreign('to_wallet_id')->references('id')->on('wallets')->onDelete('set null');
            $table->foreign('student_bill_id')->references('id')->on('student_bill')->onDelete('set null');
            $table->foreign('validated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
