@extends('layouts.admin')

@section('admin-title', 'Inquiries - Admin')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="mb-0">All Inquiries</h4>
                <p class="text-muted small mb-0">Manage and review all inquiries sent by parents to providers.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin-home') }}" class="btn btn-light">Back to Dashboard</a>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card p-3">
                    <h6 class="mb-1">Total Inquiries</h6>
                    <h3 class="mb-0">{{ $stats['total'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h6 class="mb-1">New / Pending</h6>
                    <h4 class="mb-0">{{ $stats['by_status']['pending'] ?? 0 }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h6 class="mb-1">Responded</h6>
                    <h4 class="mb-0">{{ $stats['by_status']['responded'] ?? 0 }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h6 class="mb-1">Closed</h6>
                    <h4 class="mb-0">{{ $stats['by_status']['closed'] ?? 0 }}</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    <form class="d-flex gap-2" method="GET" action="{{ route('admin.inquiries.index') }}">
                        <input type="text" name="q" class="form-control" placeholder="Search name, email, subject..." value="{{ request('q') }}">
                        <select name="status" class="form-control">
                            <option value="">All statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected':'' }}>Pending</option>
                            <option value="responded" {{ request('status') == 'responded' ? 'selected':'' }}>Responded</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected':'' }}>Closed</option>
                        </select>
                        <button class="btn btn-primary">Filter</button>
                    </form>

                    <div>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">Transactions</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Inquiry</th>
                                <th>Parent</th>
                                <th>Provider</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inquiries as $inq)
                                <tr>
                                    <td>#INQ{{ str_pad($inq->id,3,'0', STR_PAD_LEFT) }}<br><small class="text-muted">{{ Str::limit($inq->subject, 80) }}</small></td>
                                    <td>
                                        <div>{{ $inq->name }}<br><small class="text-muted">{{ $inq->email }}</small></div>
                                    </td>
                                    <td>
                                        @if($inq->provider)
                                            <a href="{{ route('admin.cleaners.show', $inq->provider->id) }}">{{ $inq->provider->name ?? $inq->provider->business_name }}</a>
                                        @else
                                            <em>(deleted)</em>
                                        @endif
                                    </td>
                                    <td>{{ $inq->provider->category->name ?? 'General' }}</td>
                                    <td>{{ $inq->created_at->format('d M Y, h:i A') }}</td>
                                    <td>{{ ucfirst($inq->status) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-secondary view-inquiry" data-inquiry='{{ json_encode([
                                                'id' => $inq->id,
                                                'name' => $inq->name,
                                                'email' => $inq->email,
                                                'message' => $inq->message,
                                                'subject' => $inq->subject,
                                                'provider_name' => $inq->provider->name ?? $inq->provider->business_name ?? '(deleted)',
                                                'date_time' => $inq->created_at->format('d M Y, h:i A'),
                                                'status' => $inq->status
                                            ]) }}' data-bs-toggle="modal" data-bs-target="#viewInquiryModal">View</button>
                                            @if($inq->status == "closed")
                                            <button class="btn btn-sm btn-success btn-resolve-inquiry disabled" data-id="{{ $inq->id }}">Resolved</button>
                                            @else
                                            
                                            @endif
                                            <button class="btn btn-sm btn-danger btn-delete-inquiry" data-id="{{ $inq->id }}">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No inquiries found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $inquiries->links() }}
                </div>
            </div>
        </div>

        <!-- View Inquiry Modal -->
        <div class="modal fade" id="viewInquiryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inquiry Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="inquiryDetails"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    // show inquiry details in modal
    document.addEventListener('click', function(e){
        if (e.target && e.target.classList.contains('view-inquiry')) {
            const data = JSON.parse(e.target.getAttribute('data-inquiry'));
            const container = document.getElementById('inquiryDetails');
            container.innerHTML = `
                <p><strong>Subject:</strong> ${data.subject}</p>
                <p><strong>Name:</strong> ${data.name} &lt;${data.email}&gt;</p>
                <p><strong>Provider:</strong> ${data.provider_name}</p>
                <p><strong>Date:</strong> ${data.date_time}</p>
                <hr>
                <pre style="white-space:pre-wrap">${data.message}</pre>
            `;
        }
    });

    // Delete inquiry (admin)
    document.querySelectorAll('.btn-delete-inquiry').forEach(btn => {
        btn.addEventListener('click', function(){
            if (!confirm('Permanently delete this inquiry?')) return;
            const id = this.dataset.id;
            fetch(`/admin/inquiries/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content') }
            }).then(r => r.json()).then(j => {
                if (j.success) location.reload(); else alert('Error deleting inquiry');
            }).catch(()=> alert('Error deleting inquiry'));
        });
    });

    // Resolve inquiry (admin)
    document.querySelectorAll('.btn-resolve-inquiry').forEach(btn => {
        btn.addEventListener('click', function(){
            if (!confirm('Mark inquiry as resolved?')) return;
            const id = this.dataset.id;
            fetch(`/admin/inquiries/${id}/resolve`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content') }
            }).then(r => r.json()).then(j => {
                if (j.success) location.reload(); else alert('Error resolving inquiry');
            }).catch(()=> alert('Error resolving inquiry'));
        });
    });
</script>
@endsection
