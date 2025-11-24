@extends('layouts.provider-layout')

@section('title', 'Payment Successful')

@section('content')
<div class="page-wrapper">

    <!-- Start Content -->
        <!-- Start Content -->
        <div class="content">    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="success-checkmark">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <h1 class="display-5 fw-bold text-success mb-3">Payment Successful!</h1>
                    <p class="lead text-muted mb-4">
                        Thank you for your payment. Your subscription has been activated successfully.
                    </p>

                    <!-- Subscription Details -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Subscription Details</h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Plan:</strong> {{ $subscription->plan->name }}</p>
                                    <p class="mb-2"><strong>Amount:</strong> ${{ number_format($subscription->amount, 2) }} {{ $subscription->currency }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Status:</strong> <span class="badge bg-success">Active</span></p>
                                    <p class="mb-2"><strong>Renews:</strong> {{ $subscription->renews_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    @if($payment)
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Payment Details</h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                                    <p class="mb-2"><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Paid Date:</strong> {{ $payment->paid_at }}</p>
                                    <p class="mb-2"><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }} {{ $payment->currency }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                        <a href="{{ route('cleaner-home') }}" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                        </a>
                        <a href="{{ route('cleaner-subscription', $subscription->id) }}" class="btn btn-outline-primary btn-lg px-5">
                            <i class="fas fa-receipt me-2"></i>View Subscription
                        </a>
                    </div>

                    <!-- Additional Help -->
                    
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-checkmark {
    width: 80px;
    height: 80px;
    margin: 0 auto;
}
.check-icon {
    width: 80px;
    height: 80px;
    position: relative;
    border-radius: 50%;
    box-sizing: content-box;
    border: 4px solid #4CAF50;
}
.check-icon::before {
    top: 3px;
    left: -2px;
    width: 30px;
    transform-origin: 100% 50%;
    border-radius: 100px 0 0 100px;
}
.check-icon::after {
    top: 0;
    left: 30px;
    width: 60px;
    transform-origin: 0 50%;
    border-radius: 0 100px 100px 0;
    animation: rotate-circle 4.25s ease-in;
}
.check-icon::before, .check-icon::after {
    content: '';
    height: 100px;
    position: absolute;
    background: #FFFFFF;
    transform: rotate(-45deg);
}
.icon-line {
    height: 5px;
    background-color: #4CAF50;
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 10;
}
.line-tip {
    top: 46px;
    left: 14px;
    width: 25px;
    transform: rotate(45deg);
    animation: icon-line-tip 0.75s;
}
.line-long {
    top: 38px;
    right: 8px;
    width: 47px;
    transform: rotate(-45deg);
    animation: icon-line-long 0.75s;
}
.icon-circle {
    top: -4px;
    left: -4px;
    z-index: 10;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    position: absolute;
    box-sizing: content-box;
    border: 4px solid rgba(76, 175, 80, .5);
}
.icon-fix {
    top: 8px;
    width: 5px;
    left: 26px;
    z-index: 1;
    height: 85px;
    position: absolute;
    transform: rotate(-45deg);
    background-color: #FFFFFF;
}

@keyframes rotate-circle {
    0% { transform: rotate(-45deg); }
    5% { transform: rotate(-45deg); }
    12% { transform: rotate(-405deg); }
    100% { transform: rotate(-405deg); }
}

@keyframes icon-line-tip {
    0% { width: 0; left: 1px; top: 19px; }
    54% { width: 0; left: 1px; top: 19px; }
    70% { width: 50px; left: -8px; top: 37px; }
    84% { width: 17px; left: 21px; top: 48px; }
    100% { width: 25px; left: 14px; top: 45px; }
}

@keyframes icon-line-long {
    0% { width: 0; right: 46px; top: 54px; }
    65% { width: 0; right: 46px; top: 54px; }
    84% { width: 55px; right: 0px; top: 35px; }
    100% { width: 47px; right: 8px; top: 38px; }
}
</style>
@endsection