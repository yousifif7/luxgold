@extends('layouts.parent-layout')

@section('title', 'My Hire Requests')

@section('content')
<div class="page-wrapper">
<div class="container mt-4">
    <h3>My Hire Requests</h3>
    <p class="text-muted">Track the status of your booking requests and view provider responses.</p>

    @if($hireRequests->count())
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Provider</th>
                    <th>Type</th>
                    <th>Scheduled</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($hireRequests as $hire)
                <tr>
                    <td>{{ $hire->id }}</td>
                    <td>{{ optional($hire->cleaner)->name ?? optional($hire->cleaner)->business_name ?? 'Cleaner' }}</td>
                    <td>{{ ucfirst($hire->cleaning_type ?? '—') }}</td>
                    <td>{{ $hire->scheduled_at ? $hire->scheduled_at->format('d M Y H:i') : '—' }}</td>
                    <td>{{ ucfirst($hire->status) }}</td>
                    <td>{{ $hire->created_at->diffForHumans() }}</td>
                    <td><a href="{{ route('hire-requests.show', $hire->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $hireRequests->links() }}

    @else
    <div class="text-center py-5">
        <p class="text-muted">You have not sent any hire requests yet.</p>
        <a href="{{ route('website.find-cleaner') }}" class="btn btn-primary">Find a Cleaner</a>
    </div>
    @endif
</div>
</div>
@endsection
