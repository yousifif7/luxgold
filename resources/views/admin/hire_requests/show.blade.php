@extends('layouts.admin')

@section('admin-title', 'Hire Request')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4>Hire Request #{{ $hireRequest->id }}</h4>
            <a href="{{ route('admin.hire-requests.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Request Details</h5>
                        <p><strong>Name:</strong> {{ $hireRequest->name }}</p>
                        <p><strong>Email:</strong> {{ $hireRequest->email }}</p>
                        <p><strong>Phone:</strong> {{ $hireRequest->phone ?? '—' }}</p>
                        <p><strong>Type:</strong> {{ $hireRequest->cleaning_type }}</p>
                        <p><strong>City:</strong> {{ $hireRequest->city ?? $hireRequest->zip_code ?? '—' }}</p>
                        <p><strong>Zip:</strong> {{ $hireRequest->zip_code }}</p>
                        <p><strong>Notes:</strong> {{ $hireRequest->notes ?? '—' }}</p>
                        @if(!empty($hireRequest->admin_message))
                            <hr>
                            <p><strong>Admin Message:</strong></p>
                            <p class="small text-muted">{{ $hireRequest->admin_message }}</p>
                        @endif
                        
                        {{-- Selected Items Details --}}
                        @php
                            $sel = $hireRequest->selected_items;
                            if (is_string($sel)) {
                                $sel = json_decode($sel, true) ?: [];
                            }
                        @endphp

                        @if(!empty($sel) && is_array($sel) && count($sel))
                            <hr>
                            <h6>Selected Items</h6>
                            <div class="table-responsive">
                                <table class="table table-sm mb-2">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Duration</th>
                                            <th class="text-end">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach($sel as $it)
                                            @php
                                                $label = is_array($it) ? ($it['label'] ?? ($it['key'] ?? json_encode($it))) : (string)$it;
                                                $duration = is_array($it) ? ($it['duration'] ?? null) : null;
                                                $price = is_array($it) ? floatval($it['price'] ?? 0) : 0;
                                                $total += $price;
                                            @endphp
                                            <tr>
                                                <td>{{ $label }}</td>
                                                <td>{{ $duration ? $duration . ' mins' : '—' }}</td>
                                                <td class="text-end">€{{ number_format($price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-end">Total</th>
                                            <th class="text-end">€{{ number_format($total, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Cleaners</h5>

                            <form method="GET" class="d-flex" action="{{ route('admin.hire-requests.show', $hireRequest->id) }}">
                                <div class="input-group">
                                    <select name="filter" class="form-select form-select-sm">
                                        <option value="" {{ empty($filter) ? 'selected' : '' }}>Recommended</option>
                                        <option value="city" {{ ($filter === 'city') ? 'selected' : '' }}>Match City</option>
                                        <option value="all" {{ ($filter === 'all') ? 'selected' : '' }}>All Cleaners</option>
                                    </select>
                                    <button class="btn btn-outline-secondary btn-sm" type="submit">Apply</button>
                                </div>
                            </form>
                        
                        
                        </div>

                        @if(empty($recommended) || $recommended->isEmpty())
                            <div class="text-muted">No cleaners found for the selected filter.</div>
                        @else
                            <form method="POST" action="{{ route('admin.hire-requests.send', $hireRequest->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <p>Select cleaners to notify about this hire request:</p>
                                </div>

                                <div class="mb-3">
                                    <label for="admin_message" class="form-label">Admin Message (optional)</label>
                                    <textarea name="admin_message" id="admin_message" class="form-control" rows="3">{{ old('admin_message', $hireRequest->admin_message ?? '') }}</textarea>
                                    <div class="form-text">A private message that will be stored on the hire request for reference.</div>
                                </div>

                                <div class="list-group">
                                    @foreach($recommended as $cleaner)
                                        <label class="list-group-item d-flex justify-content-between align-items-start">
                                            <div>
                                                <input type="checkbox" name="cleaner_ids[]" value="{{ $cleaner->id }}"> 
                                                <strong>
                                                    {{ $cleaner->first_name ?? '' }} {{ $cleaner->last_name ?? '' }}
                                                    @if(empty($cleaner->first_name) && empty($cleaner->last_name))
                                                        {{ $cleaner->name }}
                                                    @endif
                                                </strong>
                                                <div class="small text-muted">
                                                    {{ $cleaner->city ?? '—' }} @if($cleaner->zip_code) &middot; {{ $cleaner->zip_code }}@endif
                                                    &nbsp;—&nbsp; {{ $cleaner->categories?->name ?? '—' }}
                                                </div>
                                            </div>
                                            <div class="text-end small">
                                                @if(method_exists($cleaner, 'averageRating'))
                                                    <div>Rating: {{ number_format($cleaner->averageRating(), 1) }}</div>
                                                @endif
                                                <div class="text-muted">ID: {{ $cleaner->id }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-primary">Send Notifications</button>
                                    </div>
                                </form>
                            @endif

                            {{-- Assigned cleaners (if any) --}}
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
                                <div class="mt-3">
                                    <h6 class="mb-2">Assigned Cleaner{{ $assigned->count() > 1 ? 's' : '' }}</h6>
                                    <div class="row g-2">
                                        @foreach($assigned as $c)
                                            <div class="col-12 col-md-6">
                                                <div class="card h-100">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
