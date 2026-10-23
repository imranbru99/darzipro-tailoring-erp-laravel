<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('module_key')->index(); // module_tailoring, module_ecommerce, module_pos, module_karigar, module_attendance, module_ai_assistant, module_multi_branch, module_sms
            $table->string('name');
            $table->string('bangla_name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();

            $table->unique(['branch_id', 'module_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_settings');
    }
};
