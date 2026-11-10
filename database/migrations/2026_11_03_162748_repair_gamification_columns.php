<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'level')) {
                $table->integer('level')->default(1);
            }

            if (! Schema::hasColumn('users', 'exp')) {
                $table->integer('exp')->default(0);
            }

            if (! Schema::hasColumn('users', 'streak_count')) {
                $table->integer('streak_count')->default(0);
            }

            if (! Schema::hasColumn('users', 'last_active_date')) {
                $table->date('last_active_date')->nullable();
            }
        });

        Schema::table('activities', function (Blueprint $table) {
            if (! Schema::hasColumn('activities', 'xp_awarded')) {
                $table->boolean('xp_awarded')->default(false);
            }

            if (! Schema::hasColumn('activities', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // These columns may have been created by earlier migrations.
    }
};
