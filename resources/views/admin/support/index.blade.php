@extends('layouts.admin')

@section('admin-title', 'Support Tickets')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Support Tickets</h5>
                <form class="d-flex" method="GET">
                    <select name="status" class="form-select form-select-sm me-2">
                        <option value="">All</option>
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="closed">Closed</option>
                    </select>
                    <button class="btn btn-sm btn-outline-secondary">Filter</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $t)
                                <tr>
                                    <td>{{ $t->id }}</td>
                                    <td>{{ $t->subject }}</td>
                                    <td>{{ $t->name }}<br><small class="text-muted">{{ $t->email }}</small></td>
                                    <td>{{ ucfirst($t->status) }}</td>
                                    <td>{{ $t->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.support.show', $t->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        @if($t->status === 'open')
                                            <button class="btn btn-sm btn-outline-success btn-change-status" data-id="{{ $t->id }}" data-status="in_progress">Mark In Progress</button>
                                        @endif
                                        <button class="btn btn-sm btn-outline-danger btn-delete-ticket" data-id="{{ $t->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $tickets->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const token = '{{ csrf_token() }}';
    document.querySelectorAll('.btn-change-status').forEach(btn => {
        btn.addEventListener('click', function() {
            if (btn.disabled) return;
            btn.disabled = true;
            const id = this.dataset.id;
            const status = this.dataset.status;
            fetch(`/admin/support/${id}/status`, { method: 'POST', headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': token }, body: JSON.stringify({ status }) })
            .then(r => r.json()).then(j => {
                if (j.success) {
                    setTimeout(() => location.reload(), 700);
                } else {
                    btn.disabled = false;
                    alert('Error');
                }
            }).catch(e => {
                btn.disabled = false;
                console.error(e); alert('Error');
            });
        });
    });

    document.querySelectorAll('.btn-delete-ticket').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if (!confirm('Delete ticket?')) return;
            fetch(`/admin/support/${id}`, { method: 'DELETE', headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': token } })
            .then(r => r.json()).then(j => { if (j.success) location.reload(); else alert('Error'); }).catch(e => { console.error(e); alert('Error'); });
        });
    });
});
</script>
@endpush
