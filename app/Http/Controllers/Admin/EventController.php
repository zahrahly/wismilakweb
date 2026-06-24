<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Outlet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
   public function index(Request $request)
{
    $query = Event::withCount([
        'paidTickets as sold_tickets'
    ]);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    if ($request->filled('price_type') && $request->price_type !== 'all') {
        $query->where('price_type', $request->price_type);
    }

    $events = $query->latest()->get();

    return view('admin.event.index', compact('events'));
}

    public function create()
    {
        $outlets = Outlet::where('status', 'active')->get();
        return view('admin.event.create', compact('outlets'));
    }

   public function store(Request $request)
{
    $data = $request->validate([

        'title' => 'required|string|max:255',

        'date' => 'required|date|after_or_equal:today',

        'start_time' => 'nullable',

        'end_time' => 'nullable',

        'quota' => 'required|integer',

        'location' => 'required|string|max:255',

        'description' => 'nullable|string',

        'price_type' => 'required|string',

        'price' => 'nullable|numeric',

        'image' => 'nullable|image',

        'contact_person_name' => 'nullable|string',

        'contact_person_phone' => 'nullable|string',

        'is_all_outlets' => 'nullable|boolean',

        'packages' => 'nullable|array',

    ]);


    // upload poster
    if ($request->hasFile('image')) {

        $data['image'] = $request->file('image')->store('events', 'public');

    }


    // creator event
    $data['created_by'] = Auth::id();

    $data['created_by_role'] = Auth::user()->role;

    $data['status'] = 'approved';

    $data['verification_status'] = 'approved';
    
    $data['remaining_quota'] = $request->quota;


    // simpan event
    $event = Event::create($data);


    // simpan outlet jika bukan semua outlet
    if (!$request->is_all_outlets && $request->outlet_id) {
        $event->outlets()->attach($request->outlet_id, [
            'location_detail' => $request->location_detail ?? '-'
        ]);
    }


    // simpan privilege package
    if ($request->packages) {

        foreach ($request->packages as $package) {

            if ($package) {

                $event->packages()->create([

                    'title' => $package

                ]);

            }

        }

    }


    // Dispatch notifications
    try {
        // Notify Admins
        $admins = \App\Models\User::whereHas('role', function($q) { $q->where('name', 'admin'); })->get();
        foreach ($admins as $adm) {
            \App\Models\Notification::send($adm->id, 'Event Baru Dibuat', 'Event "' . $event->title . '" telah dibuat.', 'event');
        }

        // Notify Managers
        $managers = \App\Models\User::whereHas('role', function($q) { $q->where('name', 'manager'); })->get();
        foreach ($managers as $mng) {
            \App\Models\Notification::send($mng->id, 'Persetujuan Event Diperlukan', 'Event baru "' . $event->title . '" membutuhkan verifikasi dan persetujuan.', 'event');
        }
    } catch (\Exception $ne) {
        \Illuminate\Support\Facades\Log::error('Failed to send event creation notifications: ' . $ne->getMessage());
    }

    return redirect()->route('admin.event.index')
        ->with('success', 'Event berhasil ditambahkan');

}

    public function edit(Event $event)
    {
        $outlets = Outlet::where('status', 'active')->get();
        return view('admin.event.edit', compact('event', 'outlets'));
    }

    public function update(Request $request, Event $event)
{

    $data = $request->validate([

        'title' => 'required|string|max:255',

        'date' => 'required|date|after_or_equal:today',

        'start_time' => 'nullable',

        'end_time' => 'nullable',

        'quota' => 'required|integer',

        'location' => 'required|string|max:255',

        'description' => 'nullable|string',

        'price_type' => 'required|string',

        'price' => 'nullable|numeric',

        'image' => 'nullable|image',

        'contact_person_name' => 'nullable|string',

        'contact_person_phone' => 'nullable|string',

        'is_all_outlets' => 'nullable|boolean',

        'packages' => 'nullable|array',

    ]);


    // update poster
    if ($request->hasFile('image')) {

        if ($event->image) {

            Storage::disk('public')->delete($event->image);

        }

        $data['image'] = $request->file('image')->store('events', 'public');

    }

    $data['remaining_quota'] = $request->quota - (int) \App\Models\EventRegistration::where('event_id', $event->id)->where('payment_status', 'paid')->sum('quantity');

    // update event
    $event->update($data);


    // sync outlet
    $event->outlets()->detach();

    if (!$request->is_all_outlets && $request->outlet_id) {
        $event->outlets()->attach($request->outlet_id, [
            'location_detail' => $request->location_detail ?? '-'
        ]);
    }


    // update privilege package
    $event->packages()->delete();

    if ($request->packages) {

        foreach ($request->packages as $package) {

            if ($package) {

                $event->packages()->create([

                    'title' => $package

                ]);

            }

        }

    }


    // Dispatch notifications
    try {
        // Notify Admins
        $admins = \App\Models\User::whereHas('role', function($q) { $q->where('name', 'admin'); })->get();
        foreach ($admins as $adm) {
            \App\Models\Notification::send($adm->id, 'Event Diperbarui', 'Event "' . $event->title . '" telah diperbarui.', 'event');
        }

        // Notify Managers
        $managers = \App\Models\User::whereHas('role', function($q) { $q->where('name', 'manager'); })->get();
        foreach ($managers as $mng) {
            \App\Models\Notification::send($mng->id, 'Event Diperbarui', 'Event "' . $event->title . '" telah diperbarui oleh Admin.', 'event');
        }
    } catch (\Exception $ne) {
        \Illuminate\Support\Facades\Log::error('Failed to send event update notifications: ' . $ne->getMessage());
    }

    return redirect()->route('admin.event.index')
        ->with('success', 'Event berhasil diperbarui');

}
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.event.index')
                         ->with('success', 'Event berhasil dihapus');
    }
}
