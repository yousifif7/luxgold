@extends('layouts.admin')

@section('admin-title', 'Hire Requests')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4>Incoming Hire Requests</h4>
        </div>

        <div class="card">
            <div class="card-body">
                @if($requests->isEmpty())
                    <div class="text-muted">No hire requests found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Parent</th>
                                    <th>Type</th>
                                    <th>Zip</th>
                                    <th>Submitted</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $r)
                                <tr>
                                    <td>#{{ $r->id }}</td>
                                    <td>{{ $r->name }}<br><small>{{ $r->email }}</small></td>
                                    <td>{{ $r->cleaning_type }}</td>
                                    <td>{{ $r->zip_code }}</td>
                                    <td>{{ $r->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ ucfirst($r->status ?? 'new') }}</td>
                                    <td class="text-end"><a href="{{ route('admin.hire-requests.show', $r->id) }}" class="btn btn-sm btn-primary">View</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $requests->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
