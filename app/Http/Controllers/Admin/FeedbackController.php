<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventFeedback;
use App\Models\Event;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = EventFeedback::with(['event', 'user']);

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('comment', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        $feedbacks = $query->latest()->paginate(15);

        $events = Event::whereHas('feedbacks')->orderBy('title')->get();

        $stats = [
            'total'      => EventFeedback::count(),
            'avg_rating' => round(EventFeedback::avg('rating'), 1),
            'five_star'  => EventFeedback::where('rating', 5)->count(),
            'four_star'  => EventFeedback::where('rating', 4)->count(),
            'three_star' => EventFeedback::where('rating', 3)->count(),
            'two_star'   => EventFeedback::where('rating', 2)->count(),
            'one_star'   => EventFeedback::where('rating', 1)->count(),
            'distribution' => [
                EventFeedback::where('rating', 5)->count(),
                EventFeedback::where('rating', 4)->count(),
                EventFeedback::where('rating', 3)->count(),
                EventFeedback::where('rating', 2)->count(),
                EventFeedback::where('rating', 1)->count(),
            ]
        ];

        return view('admin.feedback.index', compact('feedbacks', 'events', 'stats'));
    }

    public function show(EventFeedback $feedback)
    {
        $feedback->load(['event', 'user']);
        return view('admin.feedback.show', compact('feedback'));
    }
}
