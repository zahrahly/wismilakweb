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
    Schema::table('event_registrations', function (Blueprint $table) {

        // biodata peserta
        $table->string('full_name')->after('user_id');
        $table->string('phone')->after('full_name');

        // KTP
        $table->string('ktp_number')->nullable()->after('phone');
        $table->string('ktp_file')->nullable()->after('ktp_number');

        // pembayaran
        $table->enum('payment_status', ['pending', 'paid', 'failed'])
              ->default('pending')
              ->after('ktp_file');

        $table->string('payment_proof')->nullable()
              ->after('payment_status');
    });
}

public function down(): void
{
    Schema::table('event_registrations', function (Blueprint $table) {
        $table->dropColumn([
            'full_name',
            'phone',
            'ktp_number',
            'ktp_file',
            'payment_status',
            'payment_proof'
        ]);
    });
}


};
