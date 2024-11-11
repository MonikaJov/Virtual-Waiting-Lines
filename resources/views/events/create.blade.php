<x-app-layout>
    <x-slot name="header">
        <div class="container">
            <form action="{{ isset($event) ? route('events.update', $event->id) : route('events.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($event))
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-8 offset-2">

                        <div class="row">
                            <h1>Add New Event</h1>
                        </div>
                        <div class="row">
{{--                            Name--}}
                            <label for="name" class="col-md-4 col-form-label">Name*</label>
                            <input id="name"
                                   type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   name="name"
                                   value="{{ old('name', $event->name ?? '') }}"
                                   autocomplete="name" autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                            @endif
                        </div>
{{--                        Description--}}
                        <div class="row">
                            <label for="description" class="col-md-4 col-form-label">Description</label>

                            <input id="description"
                                   type="text"
                                   class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                   name="description"
                                   value="{{ old('description', $event->description ?? '') }}"
                                   autocomplete="description" autofocus>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                            @endif
                        </div>
{{--                        Location--}}
                        <div class="row">
                            <label for="location" class="col-md-4 col-form-label">Location*</label>
                            <input id="location"
                                   type="text"
                                   class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}"
                                   name="location"
                                   value="{{ old('location', $event->location ?? '')}}"
                                   autocomplete="location" autofocus>
                            @if ($errors->has('location'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                            @endif
                        </div>
{{--                        Date--}}
                        <div class="row">
                            <label for="date" class="col-md-4 col-form-label">Date*</label>
                            <input id="date"
                                   type="date"
                                   class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}"
                                   name="date"
                                   value="{{ old('date', $event->date ?? '') }}"
                                   autocomplete="date" autofocus>
                            @if ($errors->has('date'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('date') }}</strong>
                        </span>
                            @endif
                        </div>
{{--                        Start Time--}}
                        <div class="row">
                            <label for="start_time" class="col-md-4 col-form-label">Start Time</label>
                            <input id="start_time"
                                   type="time"
                                   class="form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}"
                                   name="start_time"
                                   value="{{ old('start_time', $event->start_time ?? '') }}"
                                   autocomplete="start_time" autofocus>
                            @if ($errors->has('start_time'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('start_time') }}</strong>
                        </span>
                            @endif
                        </div>
{{--                        End Time--}}
                        <div class="row">
                            <label for="end_time" class="col-md-4 col-form-label">End Time</label>
                            <input id="end_time"
                                   type="time"
                                   class="form-control{{ $errors->has('end_time') ? ' is-invalid' : '' }}"
                                   name="end_time"
                                   value="{{ old('end_time', $event->end_time ?? '') }}"
                                   autocomplete="end_time" autofocus>
                            @if ($errors->has('end_time'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('end_time') }}</strong>
                        </span>
                            @endif
                        </div>
{{--                        Max Capacity--}}
                        <div class="row">
                            <label for="max_capacity" class="col-md-4 col-form-label">Max Capacity</label>
                            <input id="max_capacity"
                                   type="number"
                                   class="form-control{{ $errors->has('max_capacity') ? ' is-invalid' : '' }}"
                                   name="max_capacity"
                                   value="{{ old('max_capacity', $event->max_capacity ?? '') }}"
                                   autocomplete="max_capacity" autofocus>
                            @if ($errors->has('max_capacity'))
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('max_capacity') }}</strong>
                        </span>
                            @endif
                        </div>


                        <div class="row pt-4">
                            <button class="btn btn-primary">Add New Post</button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </x-slot>
</x-app-layout>
