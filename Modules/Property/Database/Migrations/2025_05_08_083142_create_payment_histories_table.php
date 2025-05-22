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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');

            // Payment Info
            $table->string('transaction_id')->unique();
            $table->enum('status', ['success', 'failed', 'pending'])->default('pending');

            // Amounts
            $table->decimal('amount', 10, 2); // Total paid (after discount)
            $table->decimal('tax', 8, 2)->nullable()->default(0);
            $table->decimal('discount', 8, 2)->nullable()->default(0);
            $table->decimal('subtotal', 10, 2)->nullable(); // before tax and discount

            // Gateway response
            $table->json('response_payload')->nullable(); // For raw response storage (in JSON for better structure)

            // Meta
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 255)->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
