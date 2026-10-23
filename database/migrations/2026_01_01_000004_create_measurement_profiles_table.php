<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurement_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('title')->default('Standard Fit'); // e.g. "ঈদের পাঞ্জাবি - লুজ ফিট", "অফিস শার্ট"
            $table->string('garment_type'); // panjabi, pajama, shirt, pant, sherwani, blazer, kamiz, salwar, blouse, burqa
            $table->json('measurements'); // JSON key-value of measurements (length, chest, waist, shoulder, etc.)
            $table->text('notes')->nullable(); // special customer fit notes
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurement_profiles');
    }
};
