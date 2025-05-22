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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // FK to users
            $table->unsignedBigInteger('property_type_id'); // FK to property_types
            $table->string('name', 50);                            // Villa/Property name
            $table->string('slug')->unique();                      // URL friendly name
            $table->json('location_gps');                          // e.g., {"lat": "12.34", "lng": "56.78"}
            $table->text('address');                               // Structured address fields (JSON)
            $table->string('phone', 20);                           // Contact number
            $table->text('description');                           // Long property description
            $table->unsignedSmallInteger('total_rooms');           // 0–65,535 rooms is enough
            $table->unsignedSmallInteger('total_capacity');        // Max people it can accommodate

            $table->boolean('is_owned')->default(false);           // true if company-owned
            $table->boolean('is_franchise')->default(false);       // true if part of franchise
            $table->boolean('is_active')->default(true);           // active status flag

            $table->json('deactivated_date')->nullable();          // e.g., {"date": "...", "reason": "..."}
            $table->date('location_start_date')->nullable();       // Date property went live
            $table->enum('billing_method', ['Card-(Visa/Master)', 'Cash', 'UPI']);    // Payment type
            $table->string('franchise_chain_name')->nullable();    // Optional franchise brand name
            $table->softDeletes();                                 // Soft Delete

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('restrict');

            $table->timestamps();                                  // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
