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
    Schema::table('media_inquiries', function (Blueprint $table) {
        $table->string('inquiry_type')->nullable()->after('subject');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media_inquiries', function (Blueprint $table) {
            //
        });
    }
};
