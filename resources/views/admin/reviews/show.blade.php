@extends('layouts.admin')
@section('title','Review Details')

@section('content')
<div class="page-wrapper">
  <div class="content">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Review Details</h5>
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-secondary">Back to Reviews</a>
      </div>
      <div class="card-body">
        <dl class="row">
          <dt class="col-sm-3">Parent</dt>
          <dd class="col-sm-9">{{ $review->parent->first_name ?? $review->parent->name ?? 'Parent' }} @if($review->parent) &lt;{{ $review->parent->email }}&gt; @endif</dd>

          <dt class="col-sm-3">Provider</dt>
          <dd class="col-sm-9">{{ $review->provider->name ?? 'Provider' }}</dd>

          <dt class="col-sm-3">Rating</dt>
          <dd class="col-sm-9">{{ $review->rating }} / 5</dd>

          <dt class="col-sm-3">Status</dt>
          <dd class="col-sm-9">{{ ucfirst($review->status) }}</dd>

          <dt class="col-sm-3">Submitted</dt>
          <dd class="col-sm-9">{{ $review->created_at->format('Y-m-d H:i') }}</dd>

          <dt class="col-sm-3">Comment</dt>
          <dd class="col-sm-9">{{ $review->comment ?? ($review->content ?? '') }}</dd>
        </dl>

        <div class="mt-3">
          <a href="#" class="btn btn-success btn-approve" data-id="{{ $review->id }}">Approve</a>
          <a href="#" class="btn btn-warning btn-flag" data-id="{{ $review->id }}">Flag</a>
          <a href="#" class="btn btn-secondary btn-reject" data-id="{{ $review->id }}">Reject</a>
          <a href="{{ route('admin.reviews.history', $review) }}" class="btn btn-light btn-history" data-id="{{ $review->id }}">History</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
