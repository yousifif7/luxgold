@extends('layouts.parent-layout')

@section('parent-title', 'Compare - Customer Portal')
@section('content')

<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">
        <div class="section-card">
            <div class="section-title">Cleaner Comparisons</div>
            <div class="section-subtitle">Compare up to 4 cleaners side by side to make the best choice</div>

            @if(isset($providers) && count($providers) > 0)
            <div class="row mb-4">
                <div class="col-md-12">
                    <h6 class="mb-3">Cleaners in Comparison</h6>
                    <div class="row g-3">
                        @foreach($providers as $provider)
                        <div class="col-md-3">
                            <div class="provider-card">
                                <div class="provider-avatar bg-primary">
                                    {{ substr($provider->name, 0, 1) }}
                                </div>
                                <div class="provider-info">
                                    <div class="provider-name">{{ $provider->name }}</div>
                                    <div class="provider-type">{{ $provider->service_categories ?? $provider->category->name ?? 'Cleaner' }}</div>
                                </div>
                                <button class="btn btn-sm btn-danger" onclick="removeFromCompare({{ $provider->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <h6 class="mb-3">Comparison Details</h6>
            <div class="table-responsive">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Feature</th>
                            @foreach($providers as $provider)
                            <th>{{ $provider->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: left; font-weight: 600;">Rating</td>
                            @foreach($providers as $provider)
                            <td>
                                @if($provider->averageRating())
                                <i class="ti ti-star-filled me-1" style="color: orange;"></i>{{ number_format($provider->averageRating(), 1) }}
                                @else
                                <span class="text-muted">No ratings</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="text-align: left; font-weight: 600;">Location</td>
                            @foreach($providers as $provider)
                            <td>
                                <i class="ti ti-map-pin me-1"></i>
                                {{ $provider->city ?? $provider->location ?? 'N/A' }}
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="text-align: left; font-weight: 600;">Price</td>
                            @foreach($providers as $provider)
                            <td>
                                @if($provider->price_amount)
                                ${{ number_format($provider->price_amount) }}{{ $provider->pricing_description ? '/'.$provider->pricing_description : '' }}
                                @else
                                <span class="text-muted">Contact for pricing</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="text-align: left; font-weight: 600;">Hours</td>
                            @foreach($providers as $provider)
                            <td>
                                <i class="ti ti-clock me-1"></i>
                                @if($provider->start_time && $provider->end_time)
                                {{ \Carbon\Carbon::parse($provider->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($provider->end_time)->format('g:i A') }}
                                @else
                                {{ $provider->available_days ?? 'Flexible' }}
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="text-align: left; font-weight: 600;">Business Type</td>
                            @foreach($providers as $provider)
                            <td>{{ $provider->business_type ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        {{-- Years, License, Insurance removed from comparison per product decision --}}
                        <tr>
                            <td style="text-align: left; font-weight: 600;">Capacity</td>
                            @foreach($providers as $provider)
                            <td>{{ $provider->capacity ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="text-align: left; font-weight: 600;">Age Range</td>
                            @foreach($providers as $provider)
                            <td>{{ $provider->age_range ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                <h5>No Cleaners to compare</h5>
                <p>Add Cleaners to your comparison list to see them side by side.</p>
                <a href="{{ route('website.find-cleaner') }}" class="btn btn-primary">Browse Cleaners</a>
            </div>
            @endif

            <div class="text-center mt-4">
{{--                 <button class="btn btn-primary me-2" onclick="saveComparison()">Save Comparison</button>
 --}}                <button class="btn btn-light border-1 border" onclick="clearComparison()">Clear All</button>
            </div>

            {{-- <div class="mt-5">
                <h6 class="mb-3">Comparison History</h6>
                <div class="provider-card">
                    <div>
                        <div class="provider-name">Preschool Options Comparison</div>
                        <div class="provider-type">Compared: Bright Futures Academy, Little Learners, Happy Kids Preschool</div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small mb-2">Mar 25, 2024</div>
                        <button class="btn btn-light border-1 border btn-sm me-2">View</button>
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- End Content -->            

</div>

<script>
// Remove provider from compare list using AJAX
function removeFromCompare(providerId) {
    if (!confirm('Are you sure you want to remove this cleaner from comparison?')) {
        return;
    }

    fetch(`/cleaners/${providerId}/compare`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            showAlert(data.message, data.in_compare === false ? 'success' : 'error');
        }
        
        // Reload the page to reflect changes
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error removing cleaner from comparison', 'error');
    });
}

// Clear all providers from compare list using AJAX
function clearComparison() {
    if (!confirm('Are you sure you want to clear all cleaners from comparison?')) {
        return;
    }

    fetch('{{ route("compare.clear") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            // Reload the page to reflect changes
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error clearing comparison list', 'error');
    });
}

// Save comparison (you can implement this based on your needs)
function saveComparison() {
    // Implement save comparison functionality
    alert('Save comparison feature to be implemented');
}

// Show alert message
function showAlert(message, type = 'info') {
    // You can use a toast library or simple alert
    alert(message); // Replace with your preferred notification system
}
</script>
@endsection