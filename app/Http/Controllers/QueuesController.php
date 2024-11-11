<?php

namespace App\Http\Controllers;

use App\Enums\QueueStatus;
use App\Models\Queue;

class QueuesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $queues = Queue::where('user_id', auth()->id())->with('event')->get();

        $userCanceledQueueIds = Queue::where('user_id', auth()->id())
            ->where('status', QueueStatus::CANCELLED)
            ->pluck('id')
            ->toArray();

        return view('queues.index', compact('queues', 'userCanceledQueueIds'));
    }
}
