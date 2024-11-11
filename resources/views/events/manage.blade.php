<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage {{$event->name}}
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
        <div class="card text-center">
            <div class="card-header">
                Location: {{$event->location}} <br/> Date: {{$event->date}} {{$event->start_time}}-{{$event->end_time}}
            </div>
            <div class="card-body">
                <p class="card-text">Average wait time:</p>
                <div class="btn-group" role="group">
                    <button style="color: white" type="button" class="btn btn-warning">Prev</button>
                    <p style="font-size: 80px">21</p>
                    <button type="button" class="btn btn-primary">Next</button>
                </div>
            </div>
            <div class="card-footer text-muted">
                <form id="manage-event-form" action="{{ route('events.manage.toggle', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button id="manage-event-button" type="submit" class="btn btn-success btn-sm">
                        {{ $isStarted ? 'End Event' : 'Start Event' }}
                    </button>
                </form>
            </div>
        </div>
        <!-- Auto-update button based on time -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const button = document.getElementById("manage-event-button");
                const startTime = "{{ $event->start_time }}";

                if (startTime) {
                    setInterval(() => {
                        const now = new Date();
                        const eventTime = new Date(startTime);

                        if (now >= eventTime) {
                            button.textContent = 'End Event';
                            button.classList.remove('btn-success');
                            button.classList.add('btn-danger');
                        }
                    }, 60000); // Check every 60 seconds
                }
            });
        </script>
    </x-slot>
</x-app-layout>
