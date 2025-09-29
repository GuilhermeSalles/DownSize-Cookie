<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'admin', 'user'])->default('user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'admin'])->default('admin')->change();
        });
    }
};
