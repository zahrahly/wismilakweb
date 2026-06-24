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
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->enum('status', ['upcoming', 'ongoing', 'completed', 'full'])
              ->default('upcoming');
        $table->enum('price_type', ['free', 'paid'])->default('free');
        $table->integer('price')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
