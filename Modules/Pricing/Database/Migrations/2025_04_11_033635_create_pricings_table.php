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
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')->constrained()->onDelete('cascade');

            $table->json('unit'); // e.g., room/unit type, name, or unit identifiers (flexible)

            $table->enum('slab', ['Monsoon', 'Sunny', 'SuperHot', 'Fall', 'Winter']); // Season

            $table->decimal('pricing', 10, 2); // Increased precision for safety

            $table->enum('pricing_type', ['Night', 'Month', 'SpecialDay']); // Billing cycle

            $table->unsignedSmallInteger('capacity');      // Ideal capacity
            $table->unsignedSmallInteger('max_capacity');  // Max capacity allowed

            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};
