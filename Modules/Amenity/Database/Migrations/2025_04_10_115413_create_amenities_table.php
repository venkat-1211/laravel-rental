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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();                                // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name', 50);                  // Amenity name (e.g., "Wi-Fi", "Pool")
            $table->string('slug')->unique();            // URL-friendly version, like "wifi", "pool"
            $table->string('icon', 50);                  // Icon name (e.g., "wifi", "pool")
            $table->boolean('is_active')->default(true)->index(); // Toggle to show/hide amenities
            $table->softDeletes();                       // For safely removing without losing data
            $table->timestamps();                        // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
