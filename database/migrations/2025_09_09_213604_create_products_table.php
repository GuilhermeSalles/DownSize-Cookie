<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('description', 600)->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('category', ['cookie','sandwich','drink','addon','other']);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->index('category', 'idx_products_category');
            $table->index('active', 'idx_products_active');
        });
    }
    public function down(): void {
        Schema::dropIfExists('products');
    }
};
