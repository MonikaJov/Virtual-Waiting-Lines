<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queues') }}
        </h2>
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-info mt-4">
                {{ session('status') }}
            </div>
        @endif
        @if (session('message'))
            <div class="alert alert-info mt-4">
                {{ session('message') }}
            </div>
        @endif
        @foreach($queues as $queue)
            @if(!in_array($queue->id, $userCanceledQueueIds))
                <div class="row pt-2 pb-4">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">

                                <h5 class="card-title">Position: {{ $queue->position }}</h5>
                                <p>Event Name: {{ $queue->event->name }}</p>
                                <p>Event Date: {{ $queue->event->date }}</p>
                                <!-- Leave Queue Button -->
                                <form class="d-inline-flex p-2"
                                      action="{{ route('events.leaveQueue', $queue->event->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Leave Queue
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            @endif
        @endforeach
    </x-slot>
</x-app-layout>
