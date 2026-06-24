<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix missing columns that earlier migrations may have failed to add
        if (Schema::hasTable('event_registrations')) {
            Schema::table('event_registrations', function (Blueprint $table) {
                if (!Schema::hasColumn('event_registrations', 'expired_at')) {
                    $table->timestamp('expired_at')->nullable();
                }
                if (!Schema::hasColumn('event_registrations', 'full_name')) {
                    $table->string('full_name')->nullable();
                }
                if (!Schema::hasColumn('event_registrations', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (!Schema::hasColumn('event_registrations', 'ktp_number')) {
                    $table->string('ktp_number')->nullable();
                }
                if (!Schema::hasColumn('event_registrations', 'ktp_file')) {
                    $table->string('ktp_file')->nullable();
                }
                if (!Schema::hasColumn('event_registrations', 'payment_proof')) {
                    $table->string('payment_proof')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // Not reverting - these are fixes for missing columns
    }
};
