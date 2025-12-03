@extends('layouts.provider-layout')

@section('title', 'Assigned Hire Requests')

@section('content')
<div class="page-wrapper">
<div class="container mt-4">
    <h3>Assigned Hire Requests</h3>
    @if($hireRequests->isEmpty())
        <p>No hire requests assigned to you yet.</p>
    @else
        <div class="list-group">
            @foreach($hireRequests as $hr)
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $hr->name }} <small class="text-muted">({{ $hr->created_at->diffForHumans() }})</small></h5>
                        <small>{{ ucfirst($hr->status) }}</small>
                    </div>
                    <p class="mb-1">Type: {{ $hr->cleaning_type ?? '-' }} | Zip: {{ $hr->zip_code ?? '-' }} | Phone: {{ $hr->phone ?? '-' }}</p>
                    
                    <p class="mb-1">
                        <strong>When:</strong>
                        @if($hr->scheduled_at)
                            {{ $hr->scheduled_at->format('d M Y H:i') }}
                        @else
                            {{ $hr->frequency ? ucfirst($hr->frequency) : '—' }}
                        @endif
                    </p>

                    <p class="mb-1">
                        <strong>Where:</strong>
                        @if(!empty($hr->city) || !empty($hr->zip_code))
                            {{ $hr->city ?? '—' }} @if($hr->zip_code) · {{ $hr->zip_code }}@endif
                        @else
                            {{ $hr->name ?? '—' }}
                        @endif
                    </p>
                    @php
                        $items = $hr->selected_items;
                        if (is_string($items)) { $items = json_decode($items, true) ?: []; }
                    @endphp
                    <div class="mb-1">
                        <strong>Items:</strong>
                        @if(!empty($items) && is_array($items) && count($items))
                            <div class="small">
                                <ul class="mb-0">
                                    @php $total = 0; @endphp
                                    @foreach($items as $it)
                                        @php
                                            $label = is_array($it) ? ($it['label'] ?? ($it['key'] ?? json_encode($it))) : (string)$it;
                                            $duration = is_array($it) ? ($it['duration'] ?? null) : null;
                                            $price = is_array($it) ? floatval($it['price'] ?? 0) : 0;
                                            $total += $price;
                                        @endphp
                                        <li>{{ $label }} @if($duration) <small class="text-muted">({{ $duration }} mins)</small> @endif — €{{ number_format($price,2) }}</li>
                                    @endforeach
                                </ul>
                                <div class="text-end small mt-1"><strong>Total: €{{ number_format($total,2) }}</strong></div>
                            </div>
                        @else
                            <span class="text-muted">No items</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-3">{{ $hireRequests->links() }}</div>
    @endif
</div>
</div>
@endsection
