<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class EventVerificationController extends Controller
{
    // Events pending & approved (ready to publish)
    public function index()
    {
        $events = Event::whereIn('verification_status', ['pending', 'approved'])
            ->orWhereIn('status', ['pending', 'approved'])
            ->with('creator')
            ->latest()
            ->get();
        return view('admin.event.verification', compact('events'));
    }

    // Terima event
    public function verify(Event $event)
    {
        $event->approve(auth()->id());

        try {
            // Notify Creator
            if ($event->created_by) {
                Notification::send($event->created_by, 'Event Disetujui', 'Event "' . $event->title . '" Anda telah disetujui.', 'verification');
            }
            // Notify Managers
            $managers = User::whereHas('role', function($q) { $q->where('name', 'manager'); })->get();
            foreach ($managers as $mng) {
                Notification::send($mng->id, 'Event Disetujui', 'Event "' . $event->title . '" telah disetujui oleh ' . auth()->user()->name . '.', 'verification');
            }
        } catch (\Exception $ne) {
            \Illuminate\Support\Facades\Log::error('Verification notification failed: ' . $ne->getMessage());
        }

        return back()->with('success', 'Event disetujui.');
    }

    // Tolak event
    public function reject(Request $request, Event $event)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:5'
        ]);

        $event->reject(auth()->id(), $request->rejection_reason);

        try {
            // Notify Creator
            if ($event->created_by) {
                Notification::send($event->created_by, 'Event Ditolak', 'Event "' . $event->title . '" Anda ditolak. Alasan: ' . $request->rejection_reason, 'verification');
            }
            // Notify Managers
            $managers = User::whereHas('role', function($q) { $q->where('name', 'manager'); })->get();
            foreach ($managers as $mng) {
                Notification::send($mng->id, 'Event Ditolak', 'Event "' . $event->title . '" telah ditolak oleh ' . auth()->user()->name . '.', 'verification');
            }
        } catch (\Exception $ne) {
            \Illuminate\Support\Facades\Log::error('Rejection notification failed: ' . $ne->getMessage());
        }

        return redirect()->route('admin.event.verification')
                         ->with('success', 'Event berhasil ditolak.');
    }

    // Publish event (approved → published)
    public function publish(Event $event)
    {
        if ($event->status !== 'approved' && $event->verification_status !== 'approved') {
            return back()->with('error', 'Event harus di-approve terlebih dahulu.');
        }

        $event->publish(auth()->id());

        try {
            // Notify Creator
            if ($event->created_by) {
                Notification::send($event->created_by, 'Event Dipublikasikan', 'Event "' . $event->title . '" Anda telah resmi dipublikasikan!', 'event');
            }
            // Notify Managers
            $managers = User::whereHas('role', function($q) { $q->where('name', 'manager'); })->get();
            foreach ($managers as $mng) {
                Notification::send($mng->id, 'Event Dipublikasikan', 'Event "' . $event->title . '" telah dipublikasikan oleh ' . auth()->user()->name . '.', 'event');
            }
        } catch (\Exception $ne) {
            \Illuminate\Support\Facades\Log::error('Publish notification failed: ' . $ne->getMessage());
        }

        return back()->with('success', 'Event berhasil dipublish!');
    }

    // Detail event (read-only)
    public function show(Event $event)
    {
        $event->load('creator', 'approver', 'publisher', 'registrations');
        return view('admin.event.detail', compact('event'));
    }

    // Unpublish event (published → approved/hidden)
    public function unpublish(Event $event)
    {
        if ($event->status !== 'published' && $event->status !== 'completed' && $event->status !== 'quota_full') {
            return back()->with('error', 'Event belum dipublikasikan.');
        }

        $event->update([
            'status' => 'approved',
            'published_by' => null,
            'published_at' => null,
        ]);

        return back()->with('success', 'Event berhasil di-hide kembali!');
    }
}
