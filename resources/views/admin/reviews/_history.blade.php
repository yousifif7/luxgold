<div class="p-3">
  <h6>Moderation History</h6>
  @if($logs->isEmpty())
    <div class="text-muted">No moderation actions recorded.</div>
  @else
    <ul class="list-unstyled">
      @foreach($logs as $log)
        <li class="mb-2">
          <div class="small text-muted">{{ $log->created_at->format('Y-m-d H:i') }} by {{ $log->adminUser->first_name ?? $log->admin_user_id }}</div>
          <div>{{ ucfirst($log->action) }} @if($log->note) - <em>{{ $log->note }}</em>@endif</div>
        </li>
      @endforeach
    </ul>
  @endif
</div>