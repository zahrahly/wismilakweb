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
        Schema::create('event_tickets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('registration_id')->constrained('event_registrations')->cascadeOnDelete();

    $table->string('full_name');
    $table->string('email');
    $table->string('phone');
    $table->date('date_of_birth');
    $table->string('ktp_number');
    $table->string('ktp_file');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_tickets');
    }
};
