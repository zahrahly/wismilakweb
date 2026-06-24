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
        Schema::table('voucher_redemptions', function (Blueprint $table) {
            $table->string('voucher_code')->unique()->after('points_spent');
            $table->enum('status', ['unused', 'used'])->default('unused')->after('voucher_code');
            $table->timestamp('expired_at')->nullable()->after('redeemed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voucher_redemptions', function (Blueprint $table) {
            $table->dropColumn(['voucher_code', 'status', 'expired_at']);
        });
    }
};
