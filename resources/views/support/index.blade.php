@extends('layouts.parent-layout')

@section('title', 'Contact & Support')

@section('content')
<div class="page-wrapper">

<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Contact & Support</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('support.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', optional(auth()->user())->first_name) . ' ' . optional(auth()->user())->last_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', optional(auth()->user())->email) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="6">{{ old('message') }}</textarea>
                        </div>
                        <button class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Your Tickets</div>
                <div class="card-body">
                    @if($tickets->isEmpty())
                        <div class="text-muted">No recent tickets</div>
                    @else
                        <ul class="list-unstyled">
                            @foreach($tickets as $t)
                                <li class="mb-2">
                                    <a href="/support/{{ $t->id }}"><strong>{{ $t->subject }}</strong></a>
                                    <div class="small text-muted">{{ $t->created_at->diffForHumans() }} — {{ ucfirst($t->status) }}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
