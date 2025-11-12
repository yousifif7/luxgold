<div class="modal-body pb-0">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Title:</strong>
                <p>{{ $event->title }}</p>
            </div>
            <div class="col-md-6">
                <strong>Subtitle:</strong>
                <p>{{ $event->subtitle ?? '—' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Provider Name:</strong>
                <p>{{ $event->provider_name ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Category:</strong>
                <p>{{ $event->category ?? '—' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Location:</strong>
                <p>{{ $event->location ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <strong>City:</strong>
                <p>{{ $event->city ?? '—' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Start Date:</strong>
                <p>{{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d M Y, h:i A') : '—' }}</p>
            </div>
            <div class="col-md-6">
                <strong>End Date:</strong>
                <p>{{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('d M Y, h:i A') : '—' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Cost:</strong>
                <p>{{ $event->cost ? '$' . number_format($event->cost, 2) : '—' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Status:</strong>
                <p class="text-capitalize">{{ $event->status ?? '—' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Max Capacity:</strong>
                <p>{{ $event->max_capacity ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Current Capacity:</strong>
                <p>{{ $event->current_capacity ?? '—' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Age Group:</strong>
                <p>{{ $event->age_group ?? '—' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Author:</strong>
                <p>{{ $event->author ?? '—' }}</p>
            </div>
        </div>

        <div class="mb-3">
            <strong>Description:</strong>
            <p>{{ $event->description ?? '—' }}</p>
        </div>

        @if($event->image_url)
            <div class="mb-3">
                <strong>Image:</strong><br>
                <img src="{{ $event->image_url }}" alt="Event Image" class="img-fluid rounded" style="max-height: 250px;">
            </div>
        @endif

        <div class="mb-3">
            <strong>Published At:</strong>
            <p>{{ $event->published_at ? \Carbon\Carbon::parse($event->published_at)->format('d M Y, h:i A') : '—' }}</p>
        </div>

        @if($event->provider)
            <div class="mb-3">
                <strong>Provider ID:</strong>
                <p>{{ $event->provider_id }}</p>
            </div>
        @endif
    </div>
</div>

<div class="modal-footer d-flex align-items-center gap-1">
    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-primary">Edit</a>
    
    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
    </form>
</div>
