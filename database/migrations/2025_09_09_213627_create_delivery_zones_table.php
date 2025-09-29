<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120)->unique('uk_delivery_zones_name');
            $table->decimal('base_fee', 10, 2);
            $table->integer('miles_limit')->default(25);
            $table->decimal('extra_per_mile', 10, 2)->default(2.00);
            $table->boolean('active')->default(true);
            $table->index('active', 'idx_delivery_zones_active');
        });
    }
    public function down(): void {
        Schema::dropIfExists('delivery_zones');
    }
};
