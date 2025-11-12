@extends('layouts.provider-layout')

@section('title', 'Payment Cancelled')

@section('content')

<div class="page-wrapper">

    <!-- Start Content -->
        <!-- Start Content -->
        <div class="content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <!-- Cancel Icon -->
                    <div class="mb-4">
                        <div class="cancel-icon mx-auto">
                            <div class="icon">
                                <div class="line left"></div>
                                <div class="line right"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancel Message -->
                    <h1 class="display-5 fw-bold text-danger mb-3">Payment Cancelled</h1>
                    <p class="lead text-muted mb-4">
                        Your payment process was cancelled. No charges have been made to your account.
                    </p>

                    <!-- Subscription Info (if any) -->
                    @if($subscription)
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Subscription Details</h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Plan:</strong> {{ $subscription->plan }}</p>
                                    <p class="mb-2"><strong>Amount:</strong> ${{ number_format($subscription->amount, 2) }} {{ $subscription->currency }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Status:</strong> <span class="badge bg-secondary">Cancelled</span></p>
                                    <p class="mb-2"><strong>Date:</strong> {{ $subscription->updated_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Reasons and Next Steps -->
                    <div class="alert alert-warning mb-4">
                        <h5 class="alert-heading">What happened?</h5>
                        <ul class="mb-0 text-start">
                            <li>You cancelled the payment process</li>
                            <li>Your card was declined</li>
                            <li>There was a technical issue</li>
                            <li>You decided to choose a different plan</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                        <a href="{{ route('subscriptions.checkout', ['plan' => $subscription->plan_id ?? '']) }}" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-credit-card me-2"></i>Try Payment Again
                        </a>
                        <a href="{{ route('provider-subscription') }}" class="btn btn-outline-primary btn-lg px-5">
                            <i class="fas fa-list me-2"></i>Choose Different Plan
                        </a>
                        <a href="{{ route('provider-home') }}" class="btn btn-outline-secondary btn-lg px-5">
                            <i class="fas fa-home me-2"></i>Back to Dashboard
                        </a>
                    </div>

                    <!-- Support Section -->
                    <div class="mt-5">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Need assistance with your payment?</h6>
                                <p class="card-text text-muted small mb-2">
                                    If you're experiencing issues with the payment process, our support team is here to help.
                                </p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="mailto:support@example.com" class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-envelope me-1"></i>Email Support
                                    </a>
                                    <a href="{{ url('support') }}" class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-life-ring me-1"></i>Help Center
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Frequently Asked Questions -->
                    <div class="mt-4">
                        <button class="btn btn-link text-muted" type="button" data-bs-toggle="collapse" data-bs-target="#faqSection">
                            <i class="fas fa-question-circle me-1"></i>Frequently Asked Questions
                        </button>
                        
                        <div class="collapse mt-3" id="faqSection">
                            <div class="card card-body text-start">
                                <h6>Why was my payment declined?</h6>
                                <p class="small text-muted mb-3">Payments can be declined due to insufficient funds, incorrect card details, or bank restrictions.</p>
                                
                                <h6>Can I use a different payment method?</h6>
                                <p class="small text-muted mb-3">Yes, you can choose from multiple payment methods including credit card, PayPal, or bank transfer.</p>
                                
                                <h6>Will I be charged if I cancel?</h6>
                                <p class="small text-muted">No, you won't be charged anything if you cancel during the payment process.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cancel-icon {
    width: 80px;
    height: 80px;
    position: relative;
}

.cancel-icon .icon {
    width: 100%;
    height: 100%;
    position: relative;
}

.cancel-icon .line {
    position: absolute;
    height: 5px;
    width: 100%;
    background-color: #dc3545;
    border-radius: 2px;
    top: 50%;
    left: 0;
}

.cancel-icon .line.left {
    transform: translateY(-50%) rotate(45deg);
}

.cancel-icon .line.right {
    transform: translateY(-50%) rotate(-45deg);
}

.cancel-icon .icon::before {
    content: '';
    position: absolute;
    top: -4px;
    left: -4px;
    right: -4px;
    bottom: -4px;
    border: 4px solid rgba(220, 53, 69, 0.2);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
    }
    
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
    }
    
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
    }
}
</style>
@endsection