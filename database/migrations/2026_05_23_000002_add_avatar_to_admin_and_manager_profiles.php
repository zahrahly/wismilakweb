<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_profiles', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('phone');
        });

        Schema::table('manager_profiles', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('admin_profiles', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });

        Schema::table('manager_profiles', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
};
