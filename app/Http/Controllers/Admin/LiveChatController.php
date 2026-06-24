<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatSession;
use App\Models\ChatMessage;


class LiveChatController extends Controller
{
    public function index(Request $request)
{
    $query = ChatSession::query();

    // FILTER STATUS
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // SEARCH
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

$sessions = $query
    ->orderByRaw("status = 'open' DESC")
    ->latest()
    ->get();

    return view('admin.livechat.index', compact('sessions'));
}


    public function show($id)
    {
        $session = ChatSession::with('messages')->findOrFail($id);
        return view('admin.livechat.show', compact('session'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $session = ChatSession::findOrFail($id);

        ChatMessage::create([
            'chat_session_id' => $id,
            'sender' => 'admin',
            'message' => $request->message
        ]);

        try {
            \App\Models\Notification::send(
                $session->user_id,
                'Balasan Chat Admin',
                "Admin telah membalas chat Anda: \"" . \Illuminate\Support\Str::limit($request->message, 50) . "\"",
                'chat'
            );
        } catch (\Exception $ne) {
            \Illuminate\Support\Facades\Log::error('Chat reply notification failed: ' . $ne->getMessage());
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    public function close($id)
    {
        $session = ChatSession::findOrFail($id);
        $session->update(['status' => 'closed']);

        try {
            \App\Models\Notification::send(
                $session->user_id,
                'Sesi Chat Ditutup',
                "Sesi chat Anda telah ditutup oleh admin. Terima kasih telah menghubungi kami.",
                'chat'
            );
        } catch (\Exception $ne) {
            \Illuminate\Support\Facades\Log::error('Chat close notification failed: ' . $ne->getMessage());
        }

        return back();
    }

    public function fetchMessages($id)
{
    $messages = ChatMessage::where('chat_session_id', $id)
        ->orderBy('created_at')
        ->get();

    return response()->json($messages);
}
public function analytics()
{
    $total = ChatSession::count();
    $open = ChatSession::where('status', 'open')->count();
    $closed = ChatSession::where('status', 'closed')->count();

    $botMessages = ChatMessage::where('sender', 'bot')->count();
    $adminMessages = ChatMessage::where('sender', 'admin')->count();

    // Ambil keyword sederhana
    $keywords = ChatMessage::where('sender', 'user')
        ->pluck('message')
        ->implode(' ');

    $keywordCount = [
        'event' => substr_count(strtolower($keywords), 'event'),
        'reward' => substr_count(strtolower($keywords), 'reward'),
        'produk' => substr_count(strtolower($keywords), 'produk'),
    ];

    return view('admin.livechat.analytics', compact(
        'total',
        'open',
        'closed',
        'botMessages',
        'adminMessages',
        'keywordCount'
    ));
}

}
