<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
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
        @can('create', App\Models\Event::class)
            <a href="/events/create">Add New Event</a>
        @endcan
        @foreach($events as $event)
            <div class="row pt-2 pb-4">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text">{{$event->description}}</p>
                            <p class="card-text">Location: {{ $event->location }}</p>
                            <p class="card-text">Date: {{ $event->date }}</p>
                            <p class="card-text">Time: {{ $event->start_time }}
                                -{{ $event->end_time }}</p>
                            @if(in_array($event->id, $userJoinedEventIds) && !in_array($event->id, $userCanceledEventIds))
                                <!-- Leave Queue Button -->
                                <form class="d-inline-flex p-2"
                                      action="{{ route('events.leaveQueue', $event->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Leave Queue
                                    </button>
                                </form>
                            @else
                                <!-- Join Queue Button -->
                                <form class="d-inline-flex p-2"
                                      action="{{ route('events.joinQueue', $event->id) }}"
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Join Queue
                                    </button>
                                </form>
                            @endif
                            <!-- Edit Queue Button -->
                            @can('update', App\Models\Event::class)
                                <a href="/events/{{ $event->id }}/edit"
                                   class="btn btn-secondary btn-sm">Edit
                                </a>
                            @endcan
                            <!-- Delete Queue Button -->
                            @can('delete', $event)
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete
                                    </button>
                                </form>
                            @endcan
                            @can('manage', $event)
                                <a href="/events/{{ $event->id }}/manage"
                                   class="btn btn-primary btn-sm">Manage
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </x-slot>
</x-app-layout>
