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
        Schema::table('events', function (Blueprint $table) {

    $table->time('start_time')->nullable();
    $table->time('end_time')->nullable();

    $table->string('contact_person_name')->nullable();
    $table->string('contact_person_phone')->nullable();

    $table->boolean('is_all_outlets')->default(false);

    $table->string('created_by_role')->nullable();

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
