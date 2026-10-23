<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tailoring_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('order_number')->unique(); // e.g. DHK-2026-0001
            $table->string('token_pin', 10)->index(); // Customer public tracking PIN e.g. "8421"
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->decimal('advance_amount', 10, 2)->default(0.00);
            $table->decimal('due_amount', 10, 2)->default(0.00);
            $table->string('payment_status')->default('unpaid'); // unpaid, partial, paid
            $table->string('order_status')->default('confirmed'); // draft, confirmed, in_cutting, in_sewing, finishing, ready_for_trial, ready_for_delivery, delivered, altered, cancelled
            $table->string('payment_method')->default('cash'); // cash, bkash, nagad, rocket, card, due
            $table->string('transaction_reference')->nullable(); // MFS TrxID
            $table->date('trial_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('tailoring_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tailoring_order_id')->constrained('tailoring_orders')->cascadeOnDelete();
            $table->foreignId('measurement_profile_id')->nullable()->constrained('measurement_profiles')->nullOnDelete();
            $table->string('garment_type'); // panjabi, pajama, shirt, pant, sherwani, blazer, kamiz, salwar, blouse, burqa
            $table->string('fabric_source')->default('customer_provided'); // customer_provided, shop_inventory
            $table->foreignId('fabric_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->decimal('fabric_yards_used', 8, 2)->default(0.00);
            $table->decimal('tailoring_price', 10, 2)->default(0.00);
            $table->decimal('fabric_price', 10, 2)->default(0.00);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->json('style_attributes')->nullable(); // Collar, pocket, sleeve, cuffs, pleats, button style
            $table->json('custom_measurements')->nullable(); // Snapshot of measurements for this order item
            $table->text('special_instructions')->nullable();
            $table->string('item_status')->default('pending'); // pending, cut, stitched, ironed, done
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tailoring_order_items');
        Schema::dropIfExists('tailoring_orders');
    }
};
