<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Transaction;
use App\Models\EventRegistration;

try {
    $partners = User::whereHas('role', fn($q) => $q->where('name', 'partner'))
        ->withCount('events')
        ->get()
        ->map(function ($partner) {
            echo "Processing Partner: " . $partner->name . "\n";
            $partner->total_revenue = Transaction::whereHas('registration.event', fn($q) => $q->where('created_by', $partner->id))
                ->where('status', 'paid')
                ->sum('amount');
            echo "  Revenue: " . $partner->total_revenue . "\n";
            $partner->total_participants = EventRegistration::whereHas('event', fn($q) => $q->where('created_by', $partner->id))
                ->where('payment_status', 'paid')
                ->sum('quantity');
            echo "  Participants: " . $partner->total_participants . "\n";
            return $partner;
        });
    echo "SUCCESS: " . $partners->count() . " partners processed.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
