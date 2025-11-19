<div class="modal-body pb-0">
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-6">
          <strong>Title:</strong>
          <p>{{ $event->title }}</p>
        </div>
        <div class="col-md-6">
          <strong>Status:</strong>
          <p class="text-capitalize">{{ $event->status }}</p>
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

      <div class="mb-3">
        <strong>Location:</strong>
        <p>{{ $event->location ?? '—' }}</p>
      </div>

      <div class="mb-3">
        <strong>Description:</strong>
        <p>{{ $event->description ?? '—' }}</p>
      </div>
    </div>
</div>
 <div class="modal-footer d-flex align-items-center gap-1">
      <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
      </form>
    </div>

