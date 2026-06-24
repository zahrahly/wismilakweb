<?php

namespace App\Http\Controllers;

use App\Models\Pressroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\MediaInquiry;
use App\Mail\MediaInquiryAutoReply;
use App\Mail\MediaInquiryNotifyAdmin;

class PressroomController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'press');

        $query = Pressroom::where('status', 'publish');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $pressrooms = $query
            ->orderBy('published_at', 'desc')
            ->paginate(6)
            ->withQueryString();

        return view('customer.pressroom.index', compact('pressrooms', 'tab'));
    }

    public function sendMediaInquiry(Request $request)
    {
        if (session()->has('inquiry_submitted') && session('inquiry_submitted') > now()->subMinutes(2)->timestamp) {
            return back()->with('error', 'Please wait a moment before submitting another inquiry.');
        }

       $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:50',
        'organization' => 'nullable|string|max:255',
        'subject' => 'nullable|string|max:255',
        'inquiry_type' => 'nullable|string|max:100',
        'message' => 'required|string|max:5000',
]);

        try {
            // Save to database
            $inquiry = MediaInquiry::create($validated);

            // Queue auto-reply to user
            Mail::to($inquiry->email)->send(new MediaInquiryAutoReply($inquiry));
            // Queue admin notification
            Mail::to(config('mail.from.address'))->send(new MediaInquiryNotifyAdmin($inquiry));
            session(['inquiry_submitted' => now()->timestamp]);

            return back()->with('success', 'Your inquiry has been submitted successfully. We will respond within 1–2 business days.');

        } catch (\Exception $e) {
            Log::error('MediaInquiry send failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'],
            ]);
            return back()->withInput()->with('error', 'Your inquiry was saved but we could not send the confirmation email. Our team will still review it.');
        }
    }

    public function show($slug)
    {
        $pressroom = Pressroom::where('slug', $slug)
                        ->where('status', 'publish')
                        ->firstOrFail();

        return view('customer.pressroom.show', compact('pressroom'));
    }
}