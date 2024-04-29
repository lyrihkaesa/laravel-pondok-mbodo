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
            $table->timestamp('transaction_date')->default(now());
            $table->string('from_wallet_id')->nullable();
            $table->string('to_wallet_id')->nullable();
            $table->timestamps();

            $table->foreign('from_wallet_id')->references('id')->on('wallets')->onDelete('set null');
            $table->foreign('to_wallet_id')->references('id')->on('wallets')->onDelete('set null');
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
