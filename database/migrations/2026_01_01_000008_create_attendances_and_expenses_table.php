<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('device_id')->nullable(); // Biometric device serial number
            $table->dateTime('punch_time');
            $table->string('punch_type')->default('check_in'); // check_in, check_out
            $table->string('verification_mode')->default('fingerprint'); // fingerprint, rfid, face, manual
            $table->string('sync_status')->default('synced'); // pending, synced, error
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Creator
            $table->string('title');
            $table->string('category')->default('other'); // rent, utility, artisan_wage, artisan_advance, haberdashery, tea_refreshment, transport, maintenance, other
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('payment_method')->default('cash'); // cash, bkash, nagad, bank_transfer
            $table->date('expense_date');
            $table->text('note')->nullable();
            $table->string('receipt_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('attendances');
    }
};
