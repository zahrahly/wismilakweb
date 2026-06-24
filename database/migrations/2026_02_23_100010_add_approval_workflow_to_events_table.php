<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite: recreate table approach to modify enum column
        // First add new columns that don't conflict
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('published_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();
        });

        // Update existing status values to match new workflow
        DB::table('events')->where('status', 'upcoming')->update(['status' => 'draft']);
        DB::table('events')->where('status', 'ongoing')->update(['status' => 'published']);
        DB::table('events')->where('status', 'completed')->update(['status' => 'published']);
        DB::table('events')->where('status', 'full')->update(['status' => 'published']);
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['approved_by', 'published_by', 'approved_at', 'published_at']);
        });
    }
};
