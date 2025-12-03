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
                    @php
                        $items = $hireRequest->selected_items;
                        if (is_string($items)) { $items = json_decode($items, true) ?: []; }
                    @endphp
                    @if(!empty($items) && is_array($items) && count($items))
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Duration</th>
                                        <th class="text-end">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($items as $it)
                                        @php
                                            $label = is_array($it) ? ($it['label'] ?? ($it['key'] ?? json_encode($it))) : (string)$it;
                                            $duration = is_array($it) ? ($it['duration'] ?? null) : null;
                                            $price = is_array($it) ? floatval($it['price'] ?? 0) : 0;
                                            $total += $price;
                                        @endphp
                                        <tr>
                                            <td>{{ $label }}</td>
                                            <td>{{ $duration ? $duration.' mins' : '—' }}</td>
                                            <td class="text-end">€{{ number_format($price,2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-end">Total</th>
                                        <th class="text-end">€{{ number_format($total,2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
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

            {{-- Assigned Cleaners --}}
            @php
                $assigned = collect();
                if (!empty($hireRequest->cleaner)) {
                    $assigned->push($hireRequest->cleaner);
                }
                if (method_exists($hireRequest, 'cleaners')) {
                    $assigned = $assigned->merge($hireRequest->cleaners());
                }
                $assigned = $assigned->unique('id')->filter();
            @endphp

            @if($assigned->isNotEmpty())
                <div class="mb-3">
                    <h6 class="mb-2">Assigned Cleaner{{ $assigned->count() > 1 ? 's' : '' }}</h6>
                    <div class="row g-2">
                        @foreach($assigned as $c)
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body d-flex">
                                        <div class="me-3">
                                            @php
                                                $avatar = $c->avatar ?? $c->logo_path ?? (is_array($c->facility_photos_paths) ? ($c->facility_photos_paths[0] ?? null) : null);
                                            @endphp
                                            @if($avatar)
                                                <img src="{{ $avatar }}" alt="{{ $c->name }}" class="rounded" style="width:72px; height:72px; object-fit:cover;">
                                            @else
                                                <div class="rounded bg-secondary text-white d-flex align-items-center justify-content-center" style="width:72px; height:72px">N/A</div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <strong>{{ ($c->first_name || $c->last_name) ? trim(($c->first_name.' '.$c->last_name)) : $c->name }}</strong>
                                            <div class="small text-muted">{{ $c->city ?? '—' }} @if($c->zip_code) · {{ $c->zip_code }}@endif</div>
                                            <div class="small text-muted">{{ $c->category?->name ?? '—' }}</div>
                                            @if(method_exists($c, 'averageRating') && $c->averageRating())
                                                <div class="small">Rating: {{ number_format($c->averageRating(), 1) }} / 5</div>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <a href="{{ route('website.cleaner-detail', $c->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <h6>Support Response</h6>
                <div class="p-3 border rounded bg-light">
                    {!! nl2br(e($hireRequest->admin_message ?? 'No response yet.')) !!}
                </div>
            </div>

            <div class="mb-3">
                <h6>Cleaner Response</h6>
                <div class="p-3 border rounded bg-light">
                    {!! nl2br(e($hireRequest->provider_message ?? 'No response yet.')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
