<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaInquiry;
use Illuminate\Http\Request;
use App\Models\MediaInquiryReply;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\MediaInquiryReplyMail;

class MediaInquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaInquiry::withCount('replies');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filter === 'unread') {
            $query->where('is_read', false);
        }

        if ($request->filter === 'unreplied') {
            $query->doesntHave('replies');
        }

        $inquiries = $query->latest()->paginate(10)->withQueryString();

        return view('admin.media_inquiries.index', compact('inquiries'));
    }

    public function show($id)
    {
        $inquiry = MediaInquiry::with('replies')->findOrFail($id);

        if (!$inquiry->is_read) {
            $inquiry->update(['is_read' => true]);
        }

        return view('admin.media_inquiries.show', compact('inquiry'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string|max:5000',
        ]);

        $inquiry = MediaInquiry::findOrFail($id);

        // Save reply to DB
        MediaInquiryReply::create([
            'media_inquiry_id' => $inquiry->id,
            'message'          => $request->reply_message,
        ]);

        // Queue the reply email
        try {
            Mail::to($inquiry->email)->send(
                new MediaInquiryReplyMail($inquiry, $request->reply_message)
            );
        } catch (\Exception $e) {
            Log::error('MediaInquiry reply email failed', [
                'inquiry_id' => $inquiry->id,
                'error'      => $e->getMessage(),
            ]);
            return back()->with('warning', 'Reply saved, but email delivery failed. Please try again.');
        }

        try {
            $admins = \App\Models\User::whereHas('role', function($q) {
                $q->where('name', 'admin');
            })->get();
            
            foreach ($admins as $admin) {
                \App\Models\Notification::send(
                    $admin->id,
                    'Media Inquiry Replied',
                    "A reply was sent to media inquiry from {$inquiry->name} by " . auth()->user()->name,
                    'media_inquiry'
                );
            }
        } catch (\Exception $ne) {
            Log::error('Media inquiry notification failed: ' . $ne->getMessage());
        }

        return back()->with('success', 'Reply sent successfully to ' . $inquiry->email);
    }

    public function destroy($id)
    {
        MediaInquiry::findOrFail($id)->delete();
        return back()->with('success', 'Inquiry deleted successfully.');
    }
}
