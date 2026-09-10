<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('pending', 'active', 'expired', 'cancelled', 'rejected') NOT NULL DEFAULT 'pending'");
        } else {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->string('status')->default('pending')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('active', 'expired', 'cancelled') NOT NULL DEFAULT 'active'");
        } else {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->string('status')->default('active')->change();
            });
        }
    }
};
