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
                    <p class="mb-1">Type: {{ $hr->cleaning_type ?? '-' }} | Zip: {{ $hr->zip_code ?? '-' }}</p>
                    <p class="mb-1">Items:
                        @if(is_array($hr->selected_items))
                            @php
                                $labels = collect($hr->selected_items)->map(function($it){
                                    if (is_string($it)) return $it;
                                    if (is_array($it) && isset($it['label'])) return $it['label'];
                                    if (is_object($it) && isset($it->label)) return $it->label;
                                    return json_encode($it);
                                })->filter()->toArray();
                            @endphp
                            {{ implode(', ', $labels) }}
                        @else
                            {{ $hr->selected_items }}
                        @endif
                    </p>
                </a>
            @endforeach
        </div>

        <div class="mt-3">{{ $hireRequests->links() }}</div>
    @endif
</div>
</div>
@endsection
