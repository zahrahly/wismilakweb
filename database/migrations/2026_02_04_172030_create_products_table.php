<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('image');
        $table->text('short_description')->nullable();
        $table->text('description')->nullable();

        // spesifikasi
        $table->string('weight')->nullable();
        $table->string('size')->nullable();
        $table->string('wrapper')->nullable();
        $table->string('filler')->nullable();
        $table->string('origin')->nullable();

        $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
