<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('vouchers', 'max_discount')) {
            Schema::table('vouchers', function (Blueprint $table) {
                $table->decimal('max_discount', 12, 2)->nullable()->after('discount_value');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('vouchers', 'max_discount')) {
            Schema::table('vouchers', function (Blueprint $table) {
                $table->dropColumn('max_discount');
            });
        }
    }
};
