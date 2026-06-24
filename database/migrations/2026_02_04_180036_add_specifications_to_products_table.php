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
    Schema::table('products', function (Blueprint $table) {
        $table->string('genome')->nullable()->after('weight');
        $table->string('assembly')->nullable()->after('genome');
        $table->string('varietal')->nullable()->after('assembly');
        $table->string('profile')->nullable()->after('filler');
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn([
            'genome',
            'assembly',
            'varietal',
            'profile'
        ]);
    });
}

};
