<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->enum('old_status', ['pending','confirmed','preparing','ready','completed','cancelled'])->nullable();
            $table->enum('new_status', ['pending','confirmed','preparing','ready','completed','cancelled']);
            $table->string('note', 400)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index('order_id', 'idx_order_events_order');
            $table->index('created_at', 'idx_order_events_created_at');
        });
    }
    public function down(): void {
        Schema::dropIfExists('order_events');
    }
};
