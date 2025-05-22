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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('phone', 20)->nullable();
            $table->string('profile_image')->nullable();

            $table->text('address')->nullable();
            $table->unsignedInteger('reward_points')->default(0);

            // JSON objects
            $table->json('aadhaar')->nullable();  // name, number, front_img, back_img
            $table->json('pan')->nullable();     // name, number, front_img, back_img
            $table->string('gst_number')->nullable(); // use string to support alphanumeric GSTIN

            $table->json('bank')->nullable();    // bank_name, account_number, ifsc
            $table->json('upi')->nullable();     // can include id, verified_at, etc.

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
