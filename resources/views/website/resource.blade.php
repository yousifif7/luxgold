@extends('layouts.master')

@section('title', $resource->meta_title ?: $resource->title)
@section('meta_description', $resource->meta_description)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">{{ $resource->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Header -->
            <header class="mb-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="badge bg-primary">
                        {{ $resource->category }}
                    </span>
                    <span class="text-muted small">{{ $resource->formatted_read_time }}</span>
                    <span class="text-muted small">{{ $resource->created_at->format('M j, Y') }}</span>
                </div>
                
                <h1 class="h2 mb-3">
                    {{ $resource->title }}
                </h1>
                
                @if($resource->description)
                <p class="lead text-muted">
                    {{ $resource->description }}
                </p>
                @endif
            </header>

            <!-- Featured Image -->
            @if($resource->image_url)
            <div class="mb-4">
                <img 
                    src="{{ $resource->image_url }}" 
                    alt="{{ $resource->title }}"
                    class="img-fluid rounded shadow"
                    style="max-height: 400px; object-fit: cover; width: 100%;"
                >
            </div>
            @endif

            <!-- Content -->
            <article class="content mb-5">
                @if($resource->content)
                    {!! $resource->content !!}
                @else
                    <div class="text-center py-5">
                        <p class="text-muted">Content coming soon...</p>
                    </div>
                @endif
            </article>

            <!-- Share Section -->
            <div class="border-top border-bottom py-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-medium">Share this resource:</span>
                    <div class="d-flex gap-3">
                        <!-- Twitter Share -->
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($resource->title) }}&url={{ urlencode(url()->current()) }}"
                           target="_blank"
                           class="text-decoration-none text-primary">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        
                        <!-- LinkedIn Share -->
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                           target="_blank"
                           class="text-decoration-none text-primary">
                            <i class="fab fa-linkedin fa-lg"></i>
                        </a>
                        
                        <!-- Facebook Share -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                           target="_blank"
                           class="text-decoration-none text-primary">
                            <i class="fab fa-facebook fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Resources -->
            @php
                $relatedResources = $resource->relatedResources(3);
            @endphp
            
            @if($relatedResources->count() > 0)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Related Resources</h5>
                    <div class="list-group list-group-flush">
                        @foreach($relatedResources as $related)
                        <a href="{{ route('website.resource', $related->slug)}}"

                           class="list-group-item list-group-item-action border-0 px-0">
                           <img src="{{ $related->image_url }}" style="height: 250px; width: 100%;">
                            <h6 class="mb-1 mt-4">{{ Str::limit($related->title) }}</h6>
                            <div class="d-flex gap-2 text-muted small">
                                <span>{{ $related->category }}</span>
                                <span>•</span>
                                <span>{{ $related->formatted_read_time }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Categories -->
            
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.content {
    line-height: 1.7;
    font-size: 1.1rem;
}

.content h1, .content h2, .content h3, .content h4 {
    color: #212529;
    font-weight: 600;
    margin-top: 2em;
    margin-bottom: 1em;
}

.content h1 { font-size: 2.25rem; }
.content h2 { font-size: 1.875rem; }
.content h3 { font-size: 1.5rem; }
.content h4 { font-size: 1.25rem; }

.content p {
    margin-bottom: 1.5rem;
}

.content ul, .content ol {
    margin-bottom: 1.5rem;
    padding-left: 1.625rem;
}

.content li {
    margin-bottom: 0.5rem;
}

.content blockquote {
    border-left: 4px solid #dee2e6;
    padding-left: 1.5rem;
    font-style: italic;
    color: #6c757d;
    margin: 2rem 0;
}

.content code {
    background-color: #f8f9fa;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}

.content pre {
    background-color: #212529;
    color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 2rem 0;
}

.content img {
    border-radius: 0.5rem;
    margin: 2rem 0;
    max-width: 100%;
    height: auto;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
    margin-bottom: 1rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}
</style>
@endpush

@push('scripts')
<!-- Font Awesome for social icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush