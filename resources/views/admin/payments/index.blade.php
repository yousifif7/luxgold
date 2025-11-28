@extends('layouts.admin')

@section('admin-title', 'Transaction Log - Admin')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="mb-0">Transaction Log</h4>
                <p class="text-muted small mb-0">All completed payments and transactions</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.payments.export') }}" class="btn btn-outline-secondary">Export CSV</a>
                <a href="{{ route('admin-home') }}" class="btn btn-light">Back to Dashboard</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Provider</th>
                                <th>Amount</th>
                                <th>Currency</th>
                                <th>Status</th>
                                <th>Paid At</th>
                                <th>Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>
                                        @if($p->provider)
                                            <a href="{{ route('admin.cleaners.show', $p->provider->id) }}">{{ $p->provider->name ?? $p->provider->business_name }}</a>
                                        @else
                                            (deleted)
                                        @endif
                                    </td>
                                    <td>${{ number_format($p->amount, 2) }}</td>
                                    <td>{{ $p->currency ?? 'USD' }}</td>
                                    <td>{{ ucfirst($p->status) }}</td>
                                    <td>{{ $p->paid_at ? $p->paid_at->format('d M Y, h:i A') : '-' }}</td>
                                    <td>{{ $p->transaction_id ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No payments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
