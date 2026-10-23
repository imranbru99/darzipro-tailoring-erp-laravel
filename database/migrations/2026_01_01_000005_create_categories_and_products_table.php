<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('bangla_name')->nullable();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('name');
            $table->string('bangla_name')->nullable();
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('product_type')->default('fabric'); // fabric, readymade, accessory, trimming
            $table->string('unit')->default('yard'); // yard (গজ), meter, piece (পিস), roll
            $table->decimal('cost_price', 10, 2)->default(0.00);
            $table->decimal('selling_price', 10, 2)->default(0.00);
            $table->decimal('stock_quantity', 10, 2)->default(0.00);
            $table->decimal('low_stock_threshold', 10, 2)->default(5.00);
            $table->string('fabric_composition')->nullable(); // Cotton, Linen, Silk, Tropical, Polyester
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
