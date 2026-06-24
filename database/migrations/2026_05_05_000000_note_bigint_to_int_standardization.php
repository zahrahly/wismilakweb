<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ============================================================================
 * NOTE: bigint → int Type Standardization
 * ============================================================================
 * 
 * Laravel's `$table->id()` and `$table->foreignId()` use `unsignedBigInteger`
 * by default. For this project's scale, `unsignedInteger` (INT UNSIGNED) is
 * sufficient and more memory-efficient.
 * 
 * This migration does NOT alter existing tables. It serves as documentation
 * of the type standardization requirement for future fresh migrations.
 * 
 * To apply these changes on an existing database, run a fresh migrate:
 *   php artisan migrate:fresh --seed
 * 
 * Alternatively, update the original migration files to use:
 *   $table->increments('id')         instead of  $table->id()
 *   $table->unsignedInteger('...')    instead of  $table->foreignId('...')
 *   + ->foreign('...')->references('id')->on('table')
 * 
 * Affected tables (all tables using $table->id() and $table->foreignId()):
 * - users, roles, events, event_registrations, galleries, products, pressrooms
 * - outlets, user_points, rewards, reward_redemptions, chat_sessions
 * - chat_messages, pages, page_sections, media_inquiries, media_inquiry_replies
 * - event_tickets, customer_profiles, admin_profiles, partner_profiles
 * - manager_profiles, transactions, vouchers, voucher_redemptions
 * - tickets, event_outlets, event_packages, partner_outlets
 * - event_feedbacks, event_checkins, point_histories
 * - outlet_products, instagram_posts, chat_topics
 * ============================================================================
 */
return new class extends Migration
{
    public function up(): void
    {
        // No-op: This migration is documentation only.
        // The type standardization should be applied by modifying
        // original migration files and running fresh migrate.
    }

    public function down(): void
    {
        // No-op
    }
};
