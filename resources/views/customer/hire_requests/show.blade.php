@extends('layouts.parent-layout')

@section('title', 'Hire Request #'.$hireRequest->id)

@section('content')
<div class="page-wrapper">
<div class="container mt-4">
    <a href="{{ route('hire-requests.index') }}" class="btn btn-link">← Back to My Hire Requests</a>
    <div class="card">
        <div class="card-body">
            <h4>Hire Request #{{ $hireRequest->id }}</h4>
            <p class="text-muted">Cleaner: {{ optional($hireRequest->cleaner)->name ?? 'Provider' }}</p>

            <div class="row mt-3">
                <div class="col-md-6">
                    <h6>Details</h6>
                    <ul class="list-unstyled">
                        <li><strong>Type:</strong> {{ ucfirst($hireRequest->cleaning_type ?? '—') }}</li>
                        <li><strong>Frequency:</strong> {{ $hireRequest->frequency ?? '—' }}</li>
                        <li><strong>Scheduled:</strong> {{ $hireRequest->scheduled_at ? $hireRequest->scheduled_at->format('d M Y H:i') : '—' }}</li>
                        <li><strong>Name:</strong> {{ $hireRequest->name }}</li>
                        <li><strong>Email:</strong> {{ $hireRequest->email }}</li>
                        <li><strong>Phone:</strong> {{ $hireRequest->phone ?? '—' }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Selected Items</h6>
                    @if($hireRequest->selected_items && is_array($hireRequest->selected_items) && count($hireRequest->selected_items))
                        <ul>
                            @foreach($hireRequest->selected_items as $item)
                                <li>{{ $item['label'] ?? $item['key'] ?? json_encode($item) }} — €{{ number_format($item['price'] ?? 0, 2) }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No items recorded.</p>
                    @endif

                    <h6 class="mt-3">Notes</h6>
                    <p>{{ $hireRequest->notes ?? '—' }}</p>
                </div>
            </div>

            <hr>
            <h6>Status & Response</h6>
            <p><strong>Status:</strong> {{ ucfirst($hireRequest->status) }} @if($hireRequest->responded_at) <small class="text-muted">(responded {{ $hireRequest->responded_at->diffForHumans() }})</small> @endif</p>

            <div class="mb-3">
                <h6>Cleaner Response</h6>
                <div class="p-3 border rounded bg-light">
                    {!! nl2br(e($hireRequest->provider_message ?? 'No response yet.')) !!}
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('website.cleaner-detail', optional($hireRequest->cleaner)->id ?? 0) }}" class="btn btn-outline-primary">View Cleaner</a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
