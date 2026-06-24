<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Customer Profiles: add preferences ──
        if (Schema::hasTable('customer_profiles') && !Schema::hasColumn('customer_profiles', 'preferences')) {
            Schema::table('customer_profiles', function (Blueprint $table) {
                $table->text('preferences')->nullable()->after('gender');
            });
        }

        // ── Partner Profiles: add business fields ──
        if (Schema::hasTable('partner_profiles')) {
            Schema::table('partner_profiles', function (Blueprint $table) {
                if (!Schema::hasColumn('partner_profiles', 'business_description')) {
                    $table->text('business_description')->nullable()->after('phone');
                }
                if (!Schema::hasColumn('partner_profiles', 'business_license')) {
                    $table->string('business_license')->nullable()->after('business_description');
                }
            });
        }

        // ── Event Registrations: ensure required columns exist ──
        if (Schema::hasTable('event_registrations')) {
            Schema::table('event_registrations', function (Blueprint $table) {
                if (!Schema::hasColumn('event_registrations', 'snap_token')) {
                    $table->string('snap_token')->nullable();
                }
                if (!Schema::hasColumn('event_registrations', 'quantity')) {
                    $table->unsignedInteger('quantity')->default(1);
                }
                if (!Schema::hasColumn('event_registrations', 'total_amount')) {
                    $table->decimal('total_amount', 12, 2)->default(0);
                }
                if (!Schema::hasColumn('event_registrations', 'ticket_price')) {
                    $table->decimal('ticket_price', 12, 2)->default(0);
                }
            });
        }

        // ── Event Feedbacks ──
        Schema::create('event_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->default(5); // 1-5
            $table->text('comment')->nullable();
            $table->unsignedInteger('points_awarded')->default(0);
            $table->timestamps();

            $table->unique(['event_id', 'user_id']); // one feedback per user per event
        });

        // ── Event Check-ins ──
        Schema::create('event_checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->timestamp('checked_in_at')->nullable();
            $table->unsignedInteger('points_awarded')->default(0);
            $table->timestamps();

            $table->unique('ticket_id'); // one check-in per ticket
        });

        // ── Point Histories ──
        Schema::create('point_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('points'); // positive = earn, negative = spend
            $table->enum('type', ['earn', 'spend']);
            $table->string('source'); // event_registration, feedback, checkin, voucher_redeem
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('description');
            $table->timestamps();

            $table->index(['user_id', 'type']);
        });

        // ── Tickets: add qr_code column if missing ──
        if (Schema::hasTable('tickets') && !Schema::hasColumn('tickets', 'qr_code')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->text('qr_code')->nullable()->after('status');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('point_histories');
        Schema::dropIfExists('event_checkins');
        Schema::dropIfExists('event_feedbacks');

        if (Schema::hasTable('tickets') && Schema::hasColumn('tickets', 'qr_code')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn('qr_code');
            });
        }

        if (Schema::hasTable('customer_profiles') && Schema::hasColumn('customer_profiles', 'preferences')) {
            Schema::table('customer_profiles', function (Blueprint $table) {
                $table->dropColumn('preferences');
            });
        }

        if (Schema::hasTable('partner_profiles')) {
            Schema::table('partner_profiles', function (Blueprint $table) {
                $columns = [];
                if (Schema::hasColumn('partner_profiles', 'business_description')) $columns[] = 'business_description';
                if (Schema::hasColumn('partner_profiles', 'business_license')) $columns[] = 'business_license';
                if (!empty($columns)) $table->dropColumn($columns);
            });
        }

        if (Schema::hasTable('event_registrations')) {
            Schema::table('event_registrations', function (Blueprint $table) {
                $columns = [];
                foreach (['snap_token', 'quantity', 'total_amount', 'ticket_price'] as $col) {
                    if (Schema::hasColumn('event_registrations', $col)) $columns[] = $col;
                }
                if (!empty($columns)) $table->dropColumn($columns);
            });
        }
    }
};
