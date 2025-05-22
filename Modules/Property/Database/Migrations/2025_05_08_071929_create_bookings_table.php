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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');

            // Dates
            $table->date('check_in');
            $table->date('check_out');
            $table->string('duration');

            // Occupancy
            $table->unsignedTinyInteger('bedrooms')->default(1);
            $table->unsignedTinyInteger('adults')->default(1);
            $table->unsignedTinyInteger('children')->default(0);

            // Coupon & Discount
            $table->string('coupon_code')->nullable();
            $table->decimal('discount', 8, 2)->default(0);

            // Price Breakdown
            $table->decimal('subtotal', 10, 2); // before tax/discount
            $table->decimal('tax', 8, 2)->default(0);
            $table->decimal('total', 10, 2); // after tax and discount

            // Booking Status
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
