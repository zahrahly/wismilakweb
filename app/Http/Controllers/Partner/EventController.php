<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\EventRegistration;
use App\Models\EventFeedback;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withSum(['registrations as registered_participants_count' => function($q) {
            $q->where('payment_status', 'paid');
        }], 'quantity')
        ->where('created_by', Auth::id())
        ->latest()
        ->paginate(10);
        return view('partner.events.index', compact('events'));
    }

    public function create()
{
    $outlets = Auth::user()->outlets;

    return view(
        'partner.events.create',
        compact('outlets')
    );
}

    public function store(Request $request)
{
    $validated = $request->validate([

        'title'       => 'required|string|max:255',

        'date'        => 'required|date|after_or_equal:today',

        'start_time'  => 'nullable',

        'end_time'    => 'nullable',

        'location'    => 'required|string|max:255',

        'quota'       => 'required|integer|min:1',

        'description' => 'required|string',

        'price_type'  => 'required|in:free,paid',

        'price'       => 'nullable|numeric|min:0',

        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        'contact_person_name'  => 'nullable|string',

        'contact_person_phone' => 'nullable|string',

        'packages' => 'nullable|array',

    ]);


    $validated['created_by']          = Auth::id();

    $validated['created_by_role']     = 'partner';

    $validated['status']              = 'draft';

    $validated['verification_status'] = 'pending';

    $validated['remaining_quota']     = $validated['quota'];


    if ($request->hasFile('image')) {

        $validated['image'] = $request->file('image')->store('events', 'public');

    }


    if ($validated['price_type'] === 'free') {

        $validated['price'] = 0;

    }


    $event = Event::create($validated);


    // simpan detail outlet partner
    if ($request->outlet_id) {
        $event->outlets()->attach($request->outlet_id, [
            'location_detail' => $request->location_detail ?? '-'
        ]);
    }


    // simpan privilege package
    if ($request->packages && isset($request->packages[0])) {
        $packages = explode("\n", $request->packages[0]);
        foreach($packages as $package){
            $package = trim($package);
            if ($package) {
                $event->packages()->create([
                    'title' => $package
                ]);
            }
        }
    }


    return redirect()->route('partner.events.index')

        ->with('success', 'Event berhasil dibuat sebagai draft.');

}

    public function edit(Event $event)
    {
        if ($event->created_by !== Auth::id()) abort(403);
        if (!in_array($event->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Event yang sudah diajukan tidak bisa diedit.');
        }
        $outlets = Auth::user()->outlets;
        return view('partner.events.edit', compact('event', 'outlets'));
    }

    public function update(Request $request, Event $event)
{
    if ($event->created_by !== Auth::id()) abort(403);


    $validated = $request->validate([

        'title'       => 'required|string|max:255',

        'date'        => 'required|date|after_or_equal:today',

        'start_time'  => 'nullable',

        'end_time'    => 'nullable',

        'location'    => 'required|string|max:255',

        'quota'       => 'required|integer|min:1',

        'description' => 'required|string',

        'price_type'  => 'required|in:free,paid',

        'price'       => 'nullable|numeric|min:0',

        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        'contact_person_name'  => 'nullable|string',

        'contact_person_phone' => 'nullable|string',

        'packages' => 'nullable|array',

    ]);


    if ($request->hasFile('image')) {

        $validated['image'] = $request->file('image')->store('events', 'public');

    }


    if ($validated['price_type'] === 'free') {

        $validated['price'] = 0;

    }


    // sync remaining quota
    $validated['remaining_quota'] =
        $validated['quota']
        -
        (int) EventRegistration::where('event_id', $event->id)
        ->where('payment_status', 'paid')
        ->sum('quantity');


    $event->update($validated);


    // update outlet detail
    $event->outlets()->detach();

    if ($request->outlet_id) {
        $event->outlets()->attach($request->outlet_id, [
            'location_detail' => $request->location_detail ?? '-'
        ]);
    }


    // update privilege package
    $event->packages()->delete();

    if ($request->packages && isset($request->packages[0])) {
        $packages = explode("\n", $request->packages[0]);
        foreach($packages as $package){
            $package = trim($package);
            if ($package) {
                $event->packages()->create([
                    'title' => $package
                ]);
            }
        }
    }


    return redirect()->route('partner.events.index')

        ->with('success', 'Event berhasil diperbarui.');

}
    public function show(Event $event)
    {
        if ($event->created_by !== Auth::id()) abort(403);

        $event->loadCount('registrations');
        $event->load(['outlets', 'packages']);

        $paidRegistrations = (int) EventRegistration::where('event_id', $event->id)
            ->where('payment_status', 'paid')
            ->sum('quantity');

        $transactions = Transaction::whereHas('registration', fn($q) => $q->where('event_id', $event->id))
            ->where('status', 'paid')
            ->get();

        $feedbackQuery = EventFeedback::where('event_id', $event->id);
        $checkinCount = Ticket::where('event_id', $event->id)
            ->whereHas('checkin')
            ->count();
        $totalTickets = Ticket::where('event_id', $event->id)->count();

        $stats = [
            'total_registrations' => $paidRegistrations,
            'total_revenue'       => $transactions->sum('amount'),
            'total_feedbacks'     => $feedbackQuery->count(),
            'avg_rating'          => round($feedbackQuery->avg('rating') ?? 0, 1),
            'total_checkins'      => $checkinCount,
            'total_tickets'       => $totalTickets,
        ];

        return view('partner.events.show', compact('event', 'stats'));
    }

    public function submit(Event $event)
    {
        if ($event->created_by !== Auth::id()) abort(403);

        if ($event->status === 'rejected') {
            $event->resubmit();
            return redirect()->route('partner.events.index')
                ->with('success', 'Event berhasil diajukan ulang untuk review admin.');
        }

        $event->submitForApproval();
        return redirect()->route('partner.events.index')
            ->with('success', 'Event berhasil diajukan untuk approval admin.');
    }

    /**
     * View participants for a specific partner event
     */
    public function participants(Event $event)
    {
        if ($event->created_by !== Auth::id()) abort(403);

        $tickets = Ticket::with(['user', 'eventRegistration'])
            ->where('event_id', $event->id)
            ->whereHas('eventRegistration', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->latest()
            ->paginate(20);

        $totalParticipants = Ticket::where('event_id', $event->id)
            ->whereHas('eventRegistration', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->count();

        return view('partner.events.participants', compact('event', 'tickets', 'totalParticipants'));
    }

    public function dashboard()
    {
        $user   = Auth::user();
        $events = Event::where('created_by', $user->id)->get();

        $stats = [
            'total_events'  => $events->count(),
            'published'     => $events->where('status', 'published')->count(),
            'pending'       => $events->where('status', 'pending')->count(),
            'rejected'      => $events->where('status', 'rejected')->count(),
            'total_revenue' => Transaction::whereHas('registration', function ($q) use ($user) {
                $q->whereHas('event', fn($e) => $e->where('created_by', $user->id));
            })->where('status', 'paid')->sum('amount'),
        ];

        $recentEvents = Event::where('created_by', $user->id)->latest()->take(5)->get();

        // Chart data: last 6 months revenue & tickets
        $months = [];
        $revenueData = [];
        $ticketsData = [];
        $checkinsData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M Y');
            $months[] = $monthName;

            // Monthly Revenue for this partner's events
            $monthlyRev = Transaction::whereHas('registration', function ($q) use ($user) {
                $q->whereHas('event', fn($e) => $e->where('created_by', $user->id));
            })
            ->where('status', 'paid')
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->sum('amount');
            $revenueData[] = (float)$monthlyRev;

            // Tickets sold
            $monthlyTickets = EventRegistration::whereHas('event', fn($e) => $e->where('created_by', $user->id))
                ->where('payment_status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('quantity');
            $ticketsData[] = (int)$monthlyTickets;

            // Tickets checked in
            $monthlyCheckins = Ticket::whereHas('event', fn($e) => $e->where('created_by', $user->id))
                ->whereHas('checkin')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $checkinsData[] = $monthlyCheckins;
        }

        $chartData = [
            'labels' => $months,
            'revenue' => $revenueData,
            'tickets' => $ticketsData,
            'checkins' => $checkinsData,
        ];

        return view('partner.dashboard', compact('stats', 'recentEvents', 'chartData'));
    }

    /**
     * View feedback for a specific partner event
     */
    public function feedbacks(Event $event)
    {
        if ($event->created_by !== Auth::id()) abort(403);

        $query = EventFeedback::where('event_id', $event->id);

        $stats = [
            'total'      => $query->count(),
            'avg_rating' => round($query->avg('rating') ?? 0, 1),
            'five_star'  => (clone $query)->where('rating', 5)->count(),
            'one_star'   => (clone $query)->where('rating', 1)->count(),
        ];

        $feedbacks = $query->with('user')->latest()->paginate(10);

        return view('partner.events.feedbacks', compact('event', 'feedbacks', 'stats'));
    }

    /**
     * View check-in history for a specific partner event
     */
    public function checkins(Event $event)
    {
        if ($event->created_by !== Auth::id()) abort(403);

        $checkins = Ticket::where('event_id', $event->id)
            ->whereHas('checkin')
            ->with(['user', 'checkin'])
            ->latest()
            ->paginate(20);

        $totalTickets = Ticket::where('event_id', $event->id)->count();
        $checkedIn = Ticket::where('event_id', $event->id)->whereHas('checkin')->count();

        return view('partner.events.checkins', compact('event', 'checkins', 'totalTickets', 'checkedIn'));
    }

    /**
     * Export event report as PDF
     */
    public function exportEventPdf(Event $event)
    {
        if ($event->created_by !== Auth::id()) abort(403);

        $event->load(['registrations' => function ($q) {
            $q->where('payment_status', 'paid')->with('user');
        }, 'feedbacks.user', 'outlets']);

        $transactions = Transaction::whereHas('registration', fn($q) => $q->where('event_id', $event->id))
            ->where('status', 'paid')
            ->get();

        $checkins = Ticket::where('event_id', $event->id)
            ->whereHas('checkin')
            ->count();

        $totalTickets = Ticket::where('event_id', $event->id)->count();

        $stats = [
            'total_registrations' => $event->registrations->count(),
            'total_revenue'       => $transactions->sum('amount'),
            'total_checkins'      => $checkins,
            'total_tickets'       => $totalTickets,
            'avg_rating'          => $event->feedbacks->count() > 0 ? round($event->feedbacks->avg('rating'), 1) : 0,
        ];

        $pdf = Pdf::loadView('partner.exports.event_report_pdf', compact('event', 'stats', 'transactions'));
        return $pdf->download('laporan_event_' . str_replace(' ', '_', $event->title) . '_' . now()->format('Ymd') . '.pdf');
    }

    /**
     * Export event report as CSV
     */
    public function exportEventCsv(Event $event)
    {
        if ($event->created_by !== Auth::id()) abort(403);

        $registrations = EventRegistration::where('event_id', $event->id)
            ->where('payment_status', 'paid')
            ->with(['user', 'transaction'])
            ->get();

        $filename = 'laporan_event_' . str_replace(' ', '_', $event->title) . '_' . now()->format('Ymd') . '.csv';
        $headers  = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"{$filename}\""];

        $callback = function () use ($registrations, $event) {
            $handle = fopen('php://output', 'w');
            // Prepend BOM and sep=, to force Microsoft Excel to split columns by comma correctly
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");
            
            fputcsv($handle, ['Event: ' . $event->title]);
            fputcsv($handle, []);
            fputcsv($handle, ['No', 'Nama', 'Email', 'Phone', 'Jumlah Tiket', 'Total Bayar', 'Status', 'Tanggal Registrasi']);
            foreach ($registrations as $i => $reg) {
                fputcsv($handle, [
                    $i + 1,
                    $reg->user->name ?? '-',
                    $reg->user->email ?? '-',
                    $reg->phone ?? '-',
                    $reg->quantity,
                    'Rp ' . number_format($reg->total_amount, 0, ',', '.'),
                    $reg->payment_status,
                    $reg->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
