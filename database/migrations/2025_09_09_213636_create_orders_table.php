<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 120);
            $table->string('customer_address', 240);
            $table->enum('service_type', ['Pick-up','Delivery']);
            $table->foreignId('delivery_zone_id')->nullable()->constrained('delivery_zones');
            $table->string('delivery_city_text', 120)->nullable();
            $table->decimal('delivery_fee', 10, 2)->nullable();
            $table->enum('delivery_day', ['Friday','Saturday'])->nullable();
            $table->time('delivery_time')->nullable();
            $table->enum('pickup_day', ['Friday','Saturday'])->nullable();
            $table->time('pickup_time')->nullable();
            $table->enum('payment_method', ['Bank Transfer','Cash']);
            $table->string('customer_observation', 600)->nullable();
            $table->string('addon_observation', 600)->nullable();
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('addons_total', 10, 2)->default(0.00);
            $table->decimal('delivery_total', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->enum('status', ['pending','confirmed','preparing','ready','completed','cancelled'])->default('pending');
            $table->timestamps();
            $table->index('service_type', 'idx_orders_service_type');
            $table->index('status', 'idx_orders_status');
            $table->index('created_at', 'idx_orders_created_at');
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
