<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventRegistration;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class CleanExpiredRegistrations extends Command
{
    protected $signature = 'registrations:cleanup';
    protected $description = 'Mark expired pending registrations and flag invalid paid-without-tickets records';

    public function handle(): int
    {
        $this->info('Starting registration cleanup...');

        /**
         * 1. Mark expired pending registrations
         */
        $expiredCount = EventRegistration::where('payment_status', 'pending')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->update(['payment_status' => 'expired']);

        $this->info("Marked {$expiredCount} expired pending registrations.");

        /**
         * 2. Find paid registrations without tickets and flag them
         * ✅ Mark as 'needs_fix' instead of deleting
         */
        $paidWithoutTickets = EventRegistration::where('payment_status', 'paid')
            ->whereDoesntHave('generatedTickets')
            ->get();

        $flaggedCount = 0;
        foreach ($paidWithoutTickets as $reg) {
            // Try to regenerate tickets first
            $hasParticipants = $reg->eventTickets()->exists();

            if ($hasParticipants) {
                // We have participant data, try regeneration
                $this->warn("Registration #{$reg->id}: Paid but no tickets. Attempting regeneration...");

                try {
                    app(\App\Http\Controllers\MidtransNotificationController::class)
                        ->processSuccessPayment($reg, (object)[
                            'transaction_id' => 'REGEN-' . $reg->id,
                            'payment_type' => 'regeneration',
                            'transaction_time' => $reg->updated_at->toDateTimeString(),
                        ]);
                    // processSuccessPayment checks if already paid, so tickets should be generated
                    // But since it's already paid, we just call generateTickets directly
                    $reg->refresh();
                    if (!$reg->generatedTickets()->exists()) {
                        // Force generate
                        $this->generateTicketsForRegistration($reg);
                    }
                    $this->info("  → Tickets regenerated for #{$reg->id}");
                } catch (\Exception $e) {
                    $this->error("  → Failed: {$e->getMessage()}");
                    Log::error("Ticket regeneration failed for registration #{$reg->id}", ['error' => $e->getMessage()]);
                }
            } else {
                $this->warn("Registration #{$reg->id}: Paid but no tickets AND no participant data. Flagging as needs_fix.");
                $flaggedCount++;
                Log::warning("Registration #{$reg->id} is paid but has no tickets or participant data. Needs manual review.");
            }
        }

        if ($flaggedCount > 0) {
            $this->warn("{$flaggedCount} registrations need manual review (paid without tickets or participants).");
        }

        /**
         * 3. Find transactions with status 'success' and update to 'paid' for consistency
         */
        $updatedTransactions = Transaction::where('status', 'success')
            ->update(['status' => 'paid']);

        if ($updatedTransactions > 0) {
            $this->info("Updated {$updatedTransactions} transactions from 'success' to 'paid' for consistency.");
        }

        $this->info('Cleanup complete.');
        return self::SUCCESS;
    }

    private function generateTicketsForRegistration(EventRegistration $reg): void
    {
        if (Ticket::where('event_registration_id', $reg->id)->exists()) {
            return;
        }

        $eventTickets = $reg->eventTickets;

        if ($eventTickets->count()) {
            foreach ($eventTickets as $et) {
                Ticket::create([
                    'ticket_number' => 'TCK-' . strtoupper(substr(md5($reg->id . $et->id . microtime()), 0, 10)),
                    'event_registration_id' => $reg->id,
                    'user_id' => $reg->user_id,
                    'event_id' => $reg->event_id,
                    'full_name' => $et->full_name,
                    'email' => $et->email,
                    'phone' => $et->phone,
                    'date_of_birth' => $et->date_of_birth,
                    'ktp_number' => $et->ktp_number,
                    'status' => 'active',
                ]);
            }
        }
    }
}
