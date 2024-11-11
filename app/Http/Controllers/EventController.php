<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\QueueStatus;
use App\Models\Event;
use App\Models\Queue;
use Carbon\Carbon;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = Event::all();
        $userJoinedEventIds = Queue::where('user_id', auth()->id())->pluck('event_id')->toArray();

        $userCanceledEventIds = Queue::where('user_id', auth()->id())
            ->where('status', QueueStatus::CANCELLED)
            ->pluck('event_id')
            ->toArray();

        return view('events.index', compact('events', 'userJoinedEventIds', 'userCanceledEventIds'));
    }

    public function create()
    {
        $this->authorize('create', Event::class);

        return view('events.create');
    }

    public function store()
    {
        $this->authorize('create', Event::class);

        $data = request()->validate([
            'name' => 'required',
            'description' => 'nullable',
            'location' => 'required',
            'date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'max_capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        auth()->user()->events()->create($data);

        return redirect('/events')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.create', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'location' => 'required',
            'date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'max_capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        $event->update($data);

        return redirect('/events')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect('/events')->with('success', 'Event deleted successfully.');
    }

    public function joinQueue(Event $event)
    {
        $user = auth()->user();

        $status = $this->hasEventStarted($event) ? 'waiting' : 'no_show';
        $position = $event->queue()->count() + 1;

        if ($event->queue()->where('user_id', $user->id)->exists()) {
            $canceledQueue = $event->queue()->where('user_id', $user->id)->where('status', QueueStatus::CANCELLED);

            if ($canceledQueue->exists()) {
                $canceledQueue->update([
                    'status' => $status,
                ]);
                return redirect()->back()->with('success', 'You have joined the queue!');
            }

            return redirect()->back()->with('message', 'You are already in the queue for this event.');
        }

        if ($this->checkEventTiming($event)) {
            $event->queue()->create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'join_time' => now(),
                'status' => $status,
                'position' => $position,
            ]);
        } else {
            return redirect()->back()->with('error', 'You cannot join the queue at this time.');
        }

        return redirect()->back()->with('success', 'You have joined the queue!');
    }

    public function leaveQueue(Event $event)
    {
        $userId = auth()->id();

        Queue::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->update([
                'status' => QueueStatus::CANCELLED,
            ]);

        return redirect()->back()->with('status', 'You have left the queue.');
    }

    public function manage(Event $event)
    {
        $this->authorize('manage', $event);

        $now = Carbon::now();
        $isStarted = $event->start_time && $now->greaterThanOrEqualTo(Carbon::parse($event->start_time));

        return view('events.manage', compact('event', 'isStarted'));
    }

    public function toggleEvent(Event $event)
    {
        $this->authorize('manage', $event);

        if (!$event->start_time) {
            $event->update(['start_time' => Carbon::now()]);
            return redirect()->back()->with('success', 'Event started successfully.');
        } else {
            $event->delete();
            return redirect()->route('events.index')->with('status', 'Event ended and deleted successfully.');
        }
    }

    public function checkEventTiming(Event $event)
    {
        $now = Carbon::now();

        $eventDate = Carbon::parse($event->date);
        $isToday = $eventDate->isToday();

        if ($event->start_time && $event->end_time) {
            $eventStartTime = Carbon::parse($event->start_time);
            $eventEndTime = Carbon::parse($event->end_time);

            $isWithinJoinTime = $now->between($eventStartTime->subHour(), $eventEndTime);

            return $isToday && $isWithinJoinTime;
        } else {
            return $isToday;
        }
    }

    public function hasEventStarted(Event $event): bool
    {
        if (is_null($event->start_time)) {
            return false;
        }

        $now = Carbon::now();
        $eventStartDateTime = Carbon::parse($event->date . ' ' . $event->start_time);

        return $now->greaterThanOrEqualTo($eventStartDateTime);
    }

    public function hasEventEnded(Event $event): bool
    {
        if (is_null($event->end_time)) {
            return false;
        }

        $eventEndDateTime = Carbon::parse($event->date . ' ' . $event->end_time);

        return Carbon::now()->greaterThan($eventEndDateTime);
    }
}

