@extends('layouts.provider-layout')

@section('provider-title', 'Subscription - Provider Portal')
@section('content')
<div class="page-wrapper">
    <!-- Subscription Page -->
    <div class="page-content container p-4">
        <div class="page-header mb-0 p-3">
            <h1 class="page-title">Subscription & Membership</h1>
            <p class="page-subtitle">Manage your subscription plan and billing information.</p>
        </div>

        <!-- Current Plan Card -->
        <div class="card">
            <div style="padding: 1.5rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 style="margin-bottom: 0.5rem;">
                            <i class="ti ti-crown" style="color: var(--primary-color);"></i> 
                            Your Current Plan
                        </h5>
                        @if($currentSubscription)
                            <h3>{{ $currentSubscription->plan->name ?? $currentSubscription->plan }}</h3>
                            <p class="text-muted">
                                ${{ number_format($currentSubscription->amount, 2) }}/month 
                                @if($currentSubscription->renews_at)
                                    • Renews on {{ $currentSubscription->renews_at->format('F d, Y') }}
                                @endif
                            </p>
                        @else
                            <h3 class="text-muted">No Active Plan</h3>
                            <p class="text-muted">Please choose a plan to get started</p>
                        @endif
                    </div>
                    <div>
                        @if($currentSubscription)
                            @if($currentSubscription->is_active)
                                <span class="status-badge status-active">Active</span>
                            @elseif($currentSubscription->status === 'cancelled')
                                <span class="status-badge status-cancelled">Cancelled</span>
                            @else
                                <span class="status-badge status-pending">Pending</span>
                            @endif
                        @else
                            <span class="status-badge status-inactive">Inactive</span>
                        @endif
                    </div>
                </div>
                
                @if($currentSubscription)
                <div class="mt-3">
                    <label class="d-flex align-items-center">
                        <input type="checkbox" id="autoRenewToggle" 
                            {{ $currentSubscription->meta['auto_renew'] ?? true ? 'checked' : '' }}
                            style="margin-right: 0.5rem;">
                        <span>
                            <strong>Auto-renewal</strong> - Automatically renew your subscription each month
                        </span>
                    </label>
                </div>
                @endif
            </div>
        </div>

        <!-- Plan Selection -->
        <h4 class="mt-4 mb-3">Choose Your Plan</h4>
        <div class="row">
            @foreach($plans as $plan)
            <div class="col-md-4 mb-4">
                <div class="plan-card {{ $currentSubscription && $currentSubscription->plan_id == $plan->id ? 'featured' : '' }}">
                    @if($plan->is_popular)
                        <span class="plan-badge popular">Most Popular</span>
                    @endif
                    @if($currentSubscription && $currentSubscription->plan_id == $plan->id)
                        <span class="plan-badge" style="top: 12px; background: var(--primary-color);">Current Plan</span>
                    @endif
                    
                    <i class="ti 
                        {{ $plan->name == 'Basic' ? 'ti-package' : ($plan->name == 'Premium' ? 'ti-crown' : 'ti-star') }}" 
                        style="font-size: 3rem; color: var(--primary-color);">
                    </i>
                    
                    <h4>{{ $plan->name }}</h4>
                    <div class="plan-price">
                        ${{ number_format($plan->monthly_fee, 2) }}<span style="font-size: 1rem; font-weight: 400;">/mo</span>
                    </div>
                    <p class="text-muted">{{ $plan->description }}</p>
                    
                    <ul class="plan-features">
                        @php
                            $features = is_array($plan->features) ? $plan->features : json_decode($plan->features, true) ?? [];
                        @endphp
                        @foreach($features as $feature => $value)
                            <li>
                                @if(is_bool($value))
                                    <i class="ti ti-{{ $value ? 'check' : 'minus' }} feature-{{ $value ? 'check' : 'dash' }}"></i>
                                    {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                @else
                                    <i class="ti ti-check feature-check"></i>
                                    {{ ucfirst(str_replace('_', ' ', $feature)) }}: {{ $value }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    
                    @if($currentSubscription && $currentSubscription->plan_id == $plan->id)
                        <button class="btn btn-primary w-100" disabled>Current Plan</button>
                    @else
                        <form action="{{ route('subscriptions.change-plan', $plan->id) }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn {{ $plan->is_popular ? 'btn-primary' : 'btn-outline-primary' }} w-100">
                                {{ $currentSubscription ? 'Switch to ' . $plan->name : 'Choose ' . $plan->name }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Feature Comparison -->
        <h4 class="mt-5 mb-3">Feature Comparison</h4>
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Features</th>
                            @foreach($plans as $plan)
                                <th>{{ $plan->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $allFeatures = [];
                            foreach($plans as $plan) {
                                $features = is_array($plan->features) ? $plan->features : json_decode($plan->features, true) ?? [];
                                $allFeatures = array_merge($allFeatures, array_keys($features));
                            }
                            $allFeatures = array_unique($allFeatures);
                        @endphp
                        
                        @foreach($allFeatures as $feature)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $feature)) }}</td>
                            @foreach($plans as $plan)
                                @php
                                    $features = is_array($plan->features) ? $plan->features : json_decode($plan->features, true) ?? [];
                                    $value = $features[$feature] ?? false;
                                @endphp
                                <td>
                                    @if(is_bool($value))
                                        <i class="ti ti-{{ $value ? 'check' : 'minus' }} feature-{{ $value ? 'check' : 'dash' }}"></i>
                                    @else
                                       ✅ 
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Billing History -->
        <h4 class="mt-5 mb-3"><i class="ti ti-file-invoice"></i> Billing History</h4>
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($billingHistory as $payment)
                        <tr>
                            <td>{{ $payment->subscription->plan->name ?? $payment->subscription->plan }}</td>
                            <td>${{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                            <td>{{ $payment->paid_at}}</td>
                            <td>
                                <span class="status-badge status-{{ $payment->status }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary" 
                                        onclick="downloadInvoice({{ $payment->id }})">
                                    <i class="ti ti-download"></i> Invoice
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No billing history found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Method -->
      
    </div>
</div>

<!-- Auto-renewal Toggle Script -->
<script>
document.getElementById('autoRenewToggle')?.addEventListener('change', function(e) {
    const isChecked = e.target.checked;
    
    fetch('{{ route("subscriptions.toggle-auto-renewal") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            subscription_id: {{ $currentSubscription->id ?? 0 }},
            auto_renew: isChecked
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
        } else {
            e.target.checked = !isChecked; // Revert on error
            showToast('error', 'Failed to update auto-renewal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        e.target.checked = !isChecked; // Revert on error
        showToast('error', 'An error occurred');
    });
});

function downloadInvoice(paymentId) {
    // Implement invoice download
    window.location.href = `/provider/invoices/${paymentId}/download`;
}

function showToast(type, message) {
    // Implement toast notification
    alert(message); // Replace with your toast implementation
}
</script>

<style>
.plan-card {
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    height: 100%;
    position: relative;
    transition: all 0.3s ease;
}

.plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.plan-card.featured {
    border: 2px solid var(--primary-color);
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
}

.plan-badge {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: #ff6b6b;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.plan-badge.popular {
    background: linear-gradient(135deg, #ff6b6b, #ff8e6b);
}

.plan-price {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin: 1rem 0;
}

.plan-features {
    list-style: none;
    padding: 0;
    margin: 1.5rem 0;
    text-align: left;
}

.plan-features li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.feature-check {
    color: #28a745;
    margin-right: 0.5rem;
}

.feature-dash {
    color: #6c757d;
    margin-right: 0.5rem;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-inactive {
    background: #e2e3e5;
    color: #383d41;
}

.status-paid {
    background: #d4edda;
    color: #155724;
}
</style>
@endsection