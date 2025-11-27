@extends('layouts.parent-layout')

@section('parent-title', 'Reviews - Customer Portal')
@section('content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">
        <div class="section-card">
            <div class="section-title">Reviews & Ratings</div>
            <div class="section-subtitle">Manage your reviews and see their approval status</div>

            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $reviews->count() }}</div>
                        <div class="stat-label">Total Reviews</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $reviews->where('status', 'approved')->count() }}</div>
                        <div class="stat-label">Approved</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $reviews->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $reviews->where('status', 'rejected')->count() }}</div>
                        <div class="stat-label">Rejected</div>
                    </div>
                </div>
            </div>

            <!-- Reviews Loop -->
            @forelse($reviews as $review)
            <div class="review-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <!-- Provider Avatar - using first letter of provider name -->
                        <div class="provider-avatar me-3 bg-primary">
                            {{ substr($review->cleaner->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="provider-name">{{ $review->cleaner->name }}</div>
                            <div class="provider-type">{{ $review->cleaner->type ?? 'Daycare Center' }}</div>
                        </div>
                    </div>
                    <div class="text-end">
                        <!-- Approval Status Badge -->
                        @if($review->status === 'approved')
                        <span class="approval-badge approval-approved">
                            <i class="fas fa-check-circle"></i> Approved
                        </span>
                        @elseif($review->status === 'pending')
                        <span class="approval-badge approval-pending">
                            <i class="fas fa-clock"></i> Pending
                        </span>
                        @else
                        <span class="approval-badge approval-rejected">
                            <i class="fas fa-times-circle"></i> Rejected
                        </span>
                        @endif
                        <div class="text-muted small mt-2">{{ $review->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
                
                <!-- Star Rating -->
                <div class="review-stars mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                        <i class="fas fa-star"></i>
                        @else
                        <i class="far fa-star"></i>
                        @endif
                    @endfor
                    <span class="ms-2">({{ $review->rating }}/5)</span>
                </div>
                
                <!-- Review Content -->
                <h6><strong>{{ $review->title ?? 'Review' }}</strong></h6>
                <p class="mb-3">{{ $review->comment }}</p>
                
                <!-- Review Stats (if available in your model) -->
             
                
                <!-- Action Buttons -->
                <div class="mt-3">
<form action="{{ route('reviews.destroy', [$review->cleaner_id, $review->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                    <a  href="{{ route('website.cleaner-detail', $review->cleaner_id) }}" class="btn btn-light border border-1 btn-sm ms-2">View Public Review</a>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                <h5>No Reviews Yet</h5>
                <p class="text-muted">You haven't written any reviews yet.</p>
                <a href="{{ route('website.find-cleaner') }}" class="btn btn-primary">Write Your First Review</a>
            </div>
            @endforelse

            <!-- Pagination (if needed) -->
          {{--   @if($reviews->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $reviews->links() }}
            </div>
            @endif --}}
        </div>
    </div>
    <!-- End Content -->            

</div>
@endsection