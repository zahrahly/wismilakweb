<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adjusts column types without dropping tables.
     */
    public function up(): void
    {
        // Adjust phone on outlets to varchar(20)
        Schema::table('outlets', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->change();
        });

        // Ensure quota is integer (may already be)
        Schema::table('events', function (Blueprint $table) {
            $table->integer('quota')->nullable()->default(0)->change();
            $table->integer('remaining_quota')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outlets', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
        });
    }
};
