@extends('layouts.admin')

@section('admin-title', 'Hire Request')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4>Hire Request #{{ $request->id }}</h4>
            <a href="{{ route('admin.hire-requests.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Request Details</h5>
                        <p><strong>Name:</strong> {{ $request->name }}</p>
                        <p><strong>Email:</strong> {{ $request->email }}</p>
                        <p><strong>Phone:</strong> {{ $request->phone ?? '—' }}</p>
                        <p><strong>Type:</strong> {{ $request->cleaning_type }}</p>
                        <p><strong>Zip:</strong> {{ $request->zip_code }}</p>
                        <p><strong>Notes:</strong> {{ $request->notes ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Recommended Cleaners</h5>

                        @if(empty($recommended) || $recommended->isEmpty())
                            <div class="text-muted">No recommended cleaners found for this request.</div>
                        @else
                            <form method="POST" action="{{ route('admin.hire-requests.send', $request->id) }}">
                                @csrf
                                <div class="mb-3">
                                    <p>Select cleaners to notify about this hire request:</p>
                                </div>

                                <div class="list-group">
                                    @foreach($recommended as $cleaner)
                                        <label class="list-group-item">
                                            <input type="checkbox" name="cleaners[]" value="{{ $cleaner->id }}"> 
                                            <strong>{{ $cleaner->name }}</strong>
                                            <div class="small text-muted">{{ $cleaner->zip_code }} — {{ $cleaner->categories?->name ?? '—' }}</div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Send Notifications</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
