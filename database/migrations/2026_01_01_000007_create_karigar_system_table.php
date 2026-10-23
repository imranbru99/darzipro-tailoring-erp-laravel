<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karigar_rates', function (Blueprint $table) {
            $table->id();
            $table->string('garment_type'); // panjabi, pajama, shirt, pant, sherwani, blazer, kamiz, salwar, blouse, burqa
            $table->string('task_type'); // cutting, stitching, finishing, embroidery, button_fixing
            $table->decimal('default_rate', 10, 2)->default(0.00);
            $table->timestamps();

            $table->unique(['garment_type', 'task_type']);
        });

        Schema::create('karigar_job_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('tailoring_order_item_id')->constrained('tailoring_order_items')->cascadeOnDelete();
            $table->foreignId('karigar_id')->constrained('users')->cascadeOnDelete(); // User with role=master_cutter or karigar
            $table->string('task_type'); // cutting, stitching, finishing, embroidery
            $table->decimal('rate', 10, 2)->default(0.00);
            $table->string('status')->default('assigned'); // assigned, in_progress, completed, inspected, rejected
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('paid_at')->nullable(); // null means wage pending; timestamp means paid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karigar_job_slips');
        Schema::dropIfExists('karigar_rates');
    }
};
