<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventFeedback;
use App\Models\EventRegistration;
use App\Models\PointHistory;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{

    public function create(Event $event)
    {
        $user = Auth::user();

        // cek user pernah ikut event
        $registration = EventRegistration::where('event_id',$event->id)
            ->where('user_id',$user->id)
            ->where('payment_status','paid')
            ->first();

        if(!$registration){
            return redirect()
                ->route('customer.dashboard')
                ->with('error','Anda belum terdaftar di event ini.');
        }

        // cek sudah check-in atau belum
        $checkedIn = Ticket::where('event_id',$event->id)
            ->where('user_id',$user->id)
            ->whereHas('checkin')
            ->exists();

        if(!$checkedIn){
            return redirect()
                ->route('customer.dashboard')
                ->with('error','Feedback hanya tersedia setelah check-in.');
        }

        // cek sudah pernah feedback
        $alreadyGiven = EventFeedback::where('event_id',$event->id)
            ->where('user_id',$user->id)
            ->exists();

        if($alreadyGiven){
            return redirect()
                ->route('customer.dashboard')
                ->with('info','Anda sudah memberi feedback.');
        }

        return view('customer.feedback.create',compact('event'));
    }



    public function store(Request $request, Event $event)
    {
    $validated = $request->validate([
        'rating'=>'required|integer|min:1|max:5',
        'comment'=>'nullable|string|max:1000',
        'image'=>'nullable|image|max:2048'
    ]);

    $user = Auth::user();

    // validasi registrasi
    $registration = EventRegistration::where('event_id',$event->id)
        ->where('user_id',$user->id)
        ->where('payment_status','paid')
        ->first();

    if(!$registration){
        abort(403);
    }

    // validasi sudah check-in
    $checkedIn = Ticket::where('event_id',$event->id)
        ->where('user_id',$user->id)
        ->whereHas('checkin')
        ->exists();

    if(!$checkedIn){
        return redirect()
            ->route('customer.dashboard')
            ->with('error','Feedback hanya tersedia setelah check-in.');
    }

    // validasi belum pernah feedback
    if(EventFeedback::where('event_id',$event->id)
        ->where('user_id',$user->id)
        ->exists()){
        return redirect()
            ->route('customer.dashboard')
            ->with('info','Feedback sudah pernah diberikan.');
    }

    try{

    $ticketCount = Ticket::where('event_id',$event->id)
        ->where('user_id',$user->id)
        ->whereHas('checkin')
        ->count();

    $pointsAwarded = 15 * $ticketCount;
    
    $imagePath = null;
    if($request->hasFile('image')){
        $imagePath = $request->file('image')->store('feedback_images','public');
    }

    EventFeedback::create([
        'event_id'=>$event->id,
        'user_id'=>$user->id,
        'rating'=>$validated['rating'],
        'comment'=>$validated['comment'] ?? null,
        'image'=>$imagePath,
        'points_awarded'=>$pointsAwarded
    ]);

    // tambah poin user
    PointHistory::earn(
        $user->id,
        $pointsAwarded,
        'feedback',
        "Feedback event: {$event->title} ({$ticketCount} tiket)",
        $event->id
    );

    // Kirim notifikasi
    try {
        \App\Models\Notification::send(
            $user->id,
            'Feedback Terkirim',
            "Terima kasih atas feedback Anda untuk event '{$event->title}'.",
            'feedback'
        );

        $admins = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'admin');
        })->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::send(
                $admin->id,
                'Feedback Baru',
                "Feedback baru dari {$user->name} untuk event '{$event->title}'.",
                'feedback'
            );
        }

        if ($event->creator && $event->creator->isPartner()) {
            \App\Models\Notification::send(
                $event->creator->id,
                'Feedback Baru',
                "Feedback baru dari {$user->name} untuk event '{$event->title}'.",
                'feedback'
            );
        }
    } catch (\Exception $ne) {
        Log::error('Feedback notifications dispatch failed: ' . $ne->getMessage());
    }

    return redirect()
        ->route('customer.dashboard')
        ->with(
            'success',
            "Terima kasih! Anda mendapat {$pointsAwarded} poin dari {$ticketCount} tiket."
        );

}catch(\Exception $e){

    Log::error('Feedback store failed',[
        'error'=>$e->getMessage()
    ]);

    return back()
        ->with('error','Gagal menyimpan feedback.');

        }
    }
public function history()
{
    $feedbacks = EventFeedback::with('event')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

    return view(
        'customer.feedback.history',
        compact('feedbacks')
    );
}
public function show(Event $event)
{
    $feedback = EventFeedback::where(
        'event_id',
        $event->id
    )->where(
        'user_id',
        Auth::id()
    )->firstOrFail();

    return view(
        'customer.feedback.show',
        compact('feedback','event')
    );
}
public function edit(Event $event)
{
    $feedback = EventFeedback::where(
        'event_id',$event->id
    )->where(
        'user_id',Auth::id()
    )->firstOrFail();

    return view(
        'customer.feedback.edit',
        compact('feedback','event')
    );
}
public function update(Request $request, Event $event)
{
    $feedback = EventFeedback::where(
        'event_id',$event->id
    )->where(
        'user_id',Auth::id()
    )->firstOrFail();

    $validated = $request->validate([
        'rating'=>'required|integer|min:1|max:5',
        'comment'=>'nullable|string|max:1000',
        'image'=>'nullable|image|max:2048'
    ]);

    if($request->hasFile('image')){
        $validated['image'] =
        $request->file('image')
        ->store('feedback_images','public');
    }

    $feedback->update($validated);

    try {
        \App\Models\Notification::send(
            Auth::id(),
            'Feedback Diperbarui',
            "Anda berhasil memperbarui feedback untuk event '{$event->title}'.",
            'feedback'
        );
    } catch (\Exception $ne) {
        Log::error('Feedback update notification failed: ' . $ne->getMessage());
    }

    return redirect()
        ->route('customer.dashboard')
        ->with('success','Feedback berhasil diperbarui.');
}
}