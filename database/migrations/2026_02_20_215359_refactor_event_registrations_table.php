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
    $table->integer('total_ticket')->default(1);
    $table->decimal('total_price',12,2)->default(0);
    $table->enum('status',['pending','verified','rejected'])->default('pending');

    $table->dropColumn(['full_name','phone','ktp_number','ktp_file']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
