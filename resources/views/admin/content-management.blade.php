@extends('layouts.admin')

@section('admin-title', 'Content Management - Admin Panel')
@section('content')
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div class="breadcrumb-arrow">
                <h4 class="mb-1">Homepage Content Management</h4>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Home</a></li>                            
                        <li class="breadcrumb-item active">Content Management</li>
                    </ol>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                <a href="javascript:void(0);" class="btn btn-icon btn-outline-light" onclick="location.reload()" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row g-2 mb-3">
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Hero Section</p>
                    <h6>{{ $heroContents->count() }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Categories</p>
                    <h6>{{ $categories->count() }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Featured Providers</p>
                    <h6>{{ $featuredProviders->count() }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Cities</p>
                    <h6>{{ $cities->count() }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Testimonials</p>
                    <h6>{{ $testimonials->count() }}</h6>
                </div>
            </div>
            <div class="col-md-2">
                <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
                    <p class="mb-2">Resources</p>
                    <h6>{{ $resources->count() }}</h6>
                </div>
            </div>
        </div>
        
        <!-- End Page Header -->
        
        <!-- Tabs for different content types -->
        <div class="card mb-4">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="contentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero" type="button" role="tab">Hero Section</button>
                    </li>
                   
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cities-tab" data-bs-toggle="tab" data-bs-target="#cities" type="button" role="tab">Cities</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="testimonials-tab" data-bs-toggle="tab" data-bs-target="#testimonials" type="button" role="tab">Testimonials</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources" type="button" role="tab">Resources</button>
                    </li>
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content" id="contentTabsContent">
                    
                    <!-- Hero Section Tab -->
                    <div class="tab-pane fade show active" id="hero" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Hero Section Content</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editHeroModal">
                                <i class="ti ti-edit me-1"></i> Edit Hero Content
                            </button>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Current Hero Content</h6>
                                        <p><strong>Title Part 1:</strong> {{ $heroContent->title_part1 ?? 'Not set' }}</p>
                                        <p><strong>Title Part 2:</strong> {{ $heroContent->title_part2 ?? 'Not set' }}</p>
                                        <p><strong>Description:</strong> {{ $heroContent->description ?? 'Not set' }}</p>
                                        <p><strong>Providers Count:</strong> {{ $heroContent->providers_count ?? 'Not set' }}</p>
                                        <p><strong>Rating:</strong> {{ $heroContent->rating ?? 'Not set' }}</p>
                                        <p><strong>Support Text:</strong> {{ $heroContent->support_text ?? 'Not set' }}</p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge {{ isset($heroContent->status) ? 'bg-success' : 'bg-secondary' }}">
                                                {{ isset($heroContent->status) ? 'Active' : 'Inactive' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Preview</h6>
                                        <div class="border rounded p-3 bg-light">
                                            <h4><span class="text-warning">{{ $heroContent->title_part1 ?? 'Your Family\'s' }}</span><br>
                                            <span class="text-success">{{ $heroContent->title_part2 ?? 'trusted guide to care, learning, activities & wellness services' }}</span></h4>
                                            <p class="text-muted mt-2">{{ $heroContent->description ?? 'Find and compare family services near you! Discover amazing daycare centers, fun activities, and wellness services that kids and parents love!' }}</p>
                                            <div class="d-flex gap-4 mt-3">
                                                <div>
                                                    <h6 class="mb-0 text-success">{{ $heroContent->providers_count ?? '500' }}+</h6>
                                                    <small>Providers</small>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-success">{{ $heroContent->rating ?? '4.8' }}</h6>
                                                    <small>Avg Rating</small>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-success">{{ $heroContent->support_text ?? '24/7' }}</h6>
                                                    <small>Support</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Categories Tab -->
                    <div class="tab-pane fade" id="categories" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Service Categories</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                <i class="ti ti-plus me-1"></i> Add Category
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAllCategories" class="form-check-input">
                                        </th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Providers</th>
                                        <th>Tags</th>
                                        <th>Status</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input category-checkbox" value="{{ $category->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $category->image_url }}" alt="{{ $category->title }}" class="rounded me-2" width="40" height="40">
                                                <div>
                                                    <strong>{{ $category->title }}</strong>
                                                    <br><small class="text-muted"><i class="{{ $category->icon_class }}"></i></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $category->subtitle }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->providers_count }}+</span>
                                        </td>
                                        <td>
                                            @php
                                                $tags = is_array($category->tags) ? $category->tags : json_decode($category->tags, true);
                                            @endphp
                                            @if(is_array($tags))
                                                @foreach(array_slice($tags, 0, 2) as $tag)
                                                    <span class="badge bg-light text-dark mb-1">{{ $tag }}</span>
                                                @endforeach
                                                @if(count($tags) > 2)
                                                    <span class="badge bg-secondary">+{{ count($tags) - 2 }} more</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                       data-id="{{ $category->id }}" 
                                                       data-type="category"
                                                    {{ $category->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm sort-order" 
                                                   value="{{ $category->sort_order }}" 
                                                   data-id="{{ $category->id }}"
                                                   data-type="category"
                                                   style="width: 70px;">
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Category Modal -->
                                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Title</label>
                                                                <input type="text" class="form-control" name="title" value="{{ $category->title }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Subtitle</label>
                                                                <input type="text" class="form-control" name="subtitle" value="{{ $category->subtitle }}" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea class="form-control" name="description" rows="3" required>{{ $category->description }}</textarea>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Providers Count</label>
                                                                <input type="number" class="form-control" name="providers_count" value="{{ $category->providers_count }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Icon Class</label>
                                                                <input type="text" class="form-control" name="icon_class" value="{{ $category->icon_class }}" placeholder="bi bi-people-fill" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Tags (comma separated)</label>
                                                                <input type="text" class="form-control" name="tags" value="{{ is_array($category->tags) ? implode(',', $category->tags) : $category->tags }}" placeholder="Daycare, Child-care, Preschool" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Image URL</label>
                                                                <input type="url" class="form-control" name="image_url" value="{{ $category->image_url }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Sort Order</label>
                                                                <input type="number" class="form-control" name="sort_order" value="{{ $category->sort_order }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <div class="form-check form-switch mt-4">
                                                                    <input class="form-check-input" type="checkbox" name="status" id="editCategoryStatus{{ $category->id }}" {{ $category->status ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="editCategoryStatus{{ $category->id }}">Active</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Category</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Actions for Categories -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <select class="form-select form-select-sm" id="categoryBulkAction" style="width: auto;">
                                    <option value="">Bulk Actions</option>
                                    <option value="activate">Activate</option>
                                    <option value="deactivate">Deactivate</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <button class="btn btn-sm btn-primary ms-2" onclick="applyBulkAction('category')">Apply</button>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!-- Cities Tab -->
                    <div class="tab-pane fade" id="cities" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Cities We Serve</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCityModal">
                                <i class="ti ti-plus me-1"></i> Add City
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAllCities" class="form-check-input">
                                        </th>
                                        <th>City</th>
                                        <th>Providers</th>
                                        <th>Families</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cities as $city)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input city-checkbox" value="{{ $city->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $city->icon_url }}" alt="{{ $city->name }}" class="rounded me-2" width="30" height="30">
                                                <div>
                                                    <strong>{{ $city->name }}, {{ $city->state }}</strong>
                                                    @if($city->link)
                                                        <br><small class="text-muted">{{ $city->link }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $city->providers_count }}+</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $city->families_count }}+</span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                       data-id="{{ $city->id }}" 
                                                       data-type="city"
                                                    {{ $city->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $city->is_coming_soon ? 'bg-warning' : 'bg-info' }}">
                                                {{ $city->is_coming_soon ? 'Coming Soon' : 'Active' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCityModal{{ $city->id }}">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this city?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit City Modal -->
                                    <div class="modal fade" id="editCityModal{{ $city->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit City</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">City Name</label>
                                                                <input type="text" class="form-control" name="name" value="{{ $city->name }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">State</label>
                                                                <input type="text" class="form-control" name="state" value="{{ $city->state }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Providers Count</label>
                                                                <input type="number" class="form-control" name="providers_count" value="{{ $city->providers_count }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Families Count</label>
                                                                <input type="number" class="form-control" name="families_count" value="{{ $city->families_count }}" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Icon URL</label>
                                                                <input type="url" class="form-control" name="icon_url" value="{{ $city->icon_url }}" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Link (optional)</label>
                                                                <input type="text" class="form-control" name="link" value="{{ $city->link }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Sort Order</label>
                                                                <input type="number" class="form-control" name="sort_order" value="{{ $city->sort_order }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <div class="form-check form-switch mt-4">
                                                                    <input class="form-check-input" type="checkbox" name="status" id="editCityStatus{{ $city->id }}" {{ $city->status ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="editCityStatus{{ $city->id }}">Active</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="is_coming_soon" id="editCityComingSoon{{ $city->id }}" {{ $city->is_coming_soon ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="editCityComingSoon{{ $city->id }}">Mark as Coming Soon</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update City</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Testimonials Tab -->
                    <div class="tab-pane fade" id="testimonials" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Parent Testimonials</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
                                <i class="ti ti-plus me-1"></i> Add Testimonial
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAllTestimonials" class="form-check-input">
                                        </th>
                                        <th>Person</th>
                                        <th>Location</th>
                                        <th>Rating</th>
                                        <th>Testimonial</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($testimonials as $testimonial)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input testimonial-checkbox" value="{{ $testimonial->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $testimonial->avatar_url }}" alt="{{ $testimonial->name }}" class="rounded me-2" width="40" height="40">
                                                <div>
                                                    <strong>{{ $testimonial->name }}</strong>
                                                    <br><small class="text-muted">{{ $testimonial->location }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $testimonial->location }}</td>
                                        <td>
                                            <span class="badge bg-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $testimonial->rating)
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($testimonial->content, 50) }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                       data-id="{{ $testimonial->id }}" 
                                                       data-type="testimonial"
                                                    {{ $testimonial->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTestimonialModal{{ $testimonial->id }}">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this testimonial?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Testimonial Modal -->
                                    <div class="modal fade" id="editTestimonialModal{{ $testimonial->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Testimonial</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Name</label>
                                                                <input type="text" class="form-control" name="name" value="{{ $testimonial->name }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Location</label>
                                                                <input type="text" class="form-control" name="location" value="{{ $testimonial->location }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Rating</label>
                                                                <select class="form-select" name="rating" required>
                                                                    <option value="5" {{ $testimonial->rating == 5 ? 'selected' : '' }}>5 Stars</option>
                                                                    <option value="4" {{ $testimonial->rating == 4 ? 'selected' : '' }}>4 Stars</option>
                                                                    <option value="3" {{ $testimonial->rating == 3 ? 'selected' : '' }}>3 Stars</option>
                                                                    <option value="2" {{ $testimonial->rating == 2 ? 'selected' : '' }}>2 Stars</option>
                                                                    <option value="1" {{ $testimonial->rating == 1 ? 'selected' : '' }}>1 Star</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Sort Order</label>
                                                                <input type="number" class="form-control" name="sort_order" value="{{ $testimonial->sort_order }}">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Testimonial Content</label>
                                                                <textarea class="form-control" name="content" rows="4" required>{{ $testimonial->content }}</textarea>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Avatar URL</label>
                                                                <input type="url" class="form-control" name="avatar_url" value="{{ $testimonial->avatar_url }}" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" name="status" id="editTestimonialStatus{{ $testimonial->id }}" {{ $testimonial->status ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="editTestimonialStatus{{ $testimonial->id }}">Active</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Testimonial</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Resources Tab -->
                    <div class="tab-pane fade" id="resources" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Parent Resources</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addResourceModal">
                                <i class="ti ti-plus me-1"></i> Add Resource
                            </button>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="selectAllResources" class="form-check-input">
                                        </th>
                                        <th>Resource</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Read Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($resources as $resource)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input resource-checkbox" value="{{ $resource->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $resource->image_url }}" alt="{{ $resource->title }}" class="rounded me-2" width="40" height="40">
                                                <div>
                                                    <strong>{{ $resource->title }}</strong>
                                                    <br><small class="text-muted">Slug: {{ $resource->slug }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $resource->category }}</span>
                                        </td>
                                        <td>{{ Str::limit($resource->description, 50) }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $resource->read_time ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status-toggle" type="checkbox" 
                                                       data-id="{{ $resource->id }}" 
                                                       data-type="resource"
                                                    {{ $resource->status ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editResourceModal{{ $resource->id }}">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this resource?')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Resource Modal -->
                                    <div class="modal fade" id="editResourceModal{{ $resource->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Resource</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.resources.update', $resource->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Title</label>
                                                                <input type="text" class="form-control" name="title" value="{{ $resource->title }}" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea class="form-control" name="description" rows="3" required>{{ $resource->description }}</textarea>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Category</label>
                                                                <input type="text" class="form-control" name="category" value="{{ $resource->category }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Read Time</label>
                                                                <input type="text" class="form-control" name="read_time" value="{{ $resource->read_time }}" placeholder="5 min read">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Image URL</label>
                                                                <input type="url" class="form-control" name="image_url" value="{{ $resource->image_url }}" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Content</label>
                                                                <textarea class="form-control" name="content" rows="6" required>{{ $resource->content }}</textarea>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Slug</label>
                                                                <input type="text" class="form-control" name="slug" value="{{ $resource->slug }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Sort Order</label>
                                                                <input type="number" class="form-control" name="sort_order" value="{{ $resource->sort_order }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Meta Title</label>
                                                                <input type="text" class="form-control" name="meta_title" value="{{ $resource->meta_title }}">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Meta Description</label>
                                                                <textarea class="form-control" name="meta_description" rows="2">{{ $resource->meta_description }}</textarea>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" name="status" id="editResourceStatus{{ $resource->id }}" {{ $resource->status ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="editResourceStatus{{ $resource->id }}">Active</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Resource</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
    <!-- End Content -->

    <!-- Add Content Modals -->

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" class="form-control" name="subtitle" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Providers Count</label>
                                <input type="number" class="form-control" name="providers_count" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Icon Class</label>
                                <input type="text" class="form-control" name="icon_class" placeholder="bi bi-people-fill" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Tags (comma separated)</label>
                                <input type="text" class="form-control" name="tags" placeholder="Daycare, Child-care, Preschool" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Image URL</label>
                                <input type="url" class="form-control" name="image_url" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" name="status" id="categoryStatus" checked>
                                    <label class="form-check-label" for="categoryStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Provider Modal -->
  

    <!-- Add City Modal -->
    <div class="modal fade" id="addCityModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.cities.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" name="state" value="TX" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Providers Count</label>
                                <input type="number" class="form-control" name="providers_count" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Families Count</label>
                                <input type="number" class="form-control" name="families_count" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Icon URL</label>
                                <input type="url" class="form-control" name="icon_url" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Link (optional)</label>
                                <input type="text" class="form-control" name="link">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" value="1" name="status" id="cityStatus" checked>
                                    <label class="form-check-label" for="cityStatus">Active</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_coming_soon" id="cityComingSoon">
                                    <label class="form-check-label" for="cityComingSoon">Mark as Coming Soon</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add City</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Testimonial Modal -->
    <div class="modal fade" id="addTestimonialModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Testimonial</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.testimonials.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rating</label>
                                <select class="form-select" name="rating" required>
                                    <option value="5">5 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="2">2 Stars</option>
                                    <option value="1">1 Star</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="0">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Testimonial Content</label>
                                <textarea class="form-control" name="content" rows="4" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Avatar URL</label>
                                <input type="url" class="form-control" name="avatar_url" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" id="testimonialStatus" checked>
                                    <label class="form-check-label" for="testimonialStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Resource Modal -->
    <div class="modal fade" id="addResourceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Resource</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.resources.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Read Time</label>
                                <input type="text" class="form-control" name="read_time" placeholder="5 min read">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Image URL</label>
                                <input type="url" class="form-control" name="image_url" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Content</label>
                                <textarea class="form-control" name="content" rows="6" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" name="slug" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" name="sort_order" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" id="resourceStatus" checked>
                                    <label class="form-check-label" for="resourceStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Resource</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Hero Modal -->
    <div class="modal fade" id="editHeroModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Hero Section Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.hero.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title Part 1</label>
                                <input type="text" class="form-control" name="title_part1" value="{{ $heroContent->title_part1 ?? '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title Part 2</label>
                                <input type="text" class="form-control" name="title_part2" value="{{ $heroContent->title_part2 ?? '' }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" required>{{ $heroContent->description ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Providers Count</label>
                                <input type="number" class="form-control" name="providers_count" value="{{ $heroContent->providers_count ?? '' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Rating</label>
                                <input type="number" step="0.1" class="form-control" name="rating" value="{{ $heroContent->rating ?? '' }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Support Text</label>
                                <input type="text" class="form-control" name="support_text" value="{{ $heroContent->support_text ?? '' }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" value="1" name="status" id="heroStatus" {{ ($heroContent->status ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="heroStatus">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript for Interactive Features -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Toggle
    const statusToggles = document.querySelectorAll('.status-toggle');
    statusToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.dataset.id;
            const type = this.dataset.type;
            const status = this.checked;
            
            fetch(`/admin/toggle-status/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    type: type,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Status updated successfully!', 'success');
                } else {
                    showToast('Error updating status!', 'error');
                    this.checked = !status; // Revert on error
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error updating status!', 'error');
                this.checked = !status; // Revert on error
            });
        });
    });

    // Sort Order Update
    const sortOrders = document.querySelectorAll('.sort-order');
    sortOrders.forEach(input => {
        input.addEventListener('change', function() {
            const id = this.dataset.id;
            const type = this.dataset.type;
            const value = this.value;
            
            // You can implement AJAX call here to update sort order
            console.log(`Updating ${type} ${id} sort order to ${value}`);
        });
    });

    // Select All Checkboxes
    const selectAllCheckboxes = document.querySelectorAll('input[id^="selectAll"]');
    selectAllCheckboxes.forEach(selectAll => {
        selectAll.addEventListener('change', function() {
            const tableType = this.id.replace('selectAll', '').toLowerCase();
            const checkboxes = document.querySelectorAll(`.${tableType}-checkbox`);
            check.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    });

    // Bulk Actions
    window.applyBulkAction = function(type) {
        const action = document.getElementById(`${type}BulkAction`).value;
        const checkboxes = document.querySelectorAll(`.${type}-checkbox:checked`);
        const ids = Array.from(checkboxes).map(cb => cb.value);
        
        if (ids.length === 0) {
            showToast('Please select items to perform action.', 'warning');
            return;
        }
        
        if (!action) {
            showToast('Please select an action.', 'warning');
            return;
        }
        
        if (confirm(`Are you sure you want to ${action} ${ids.length} item(s)?`)) {
            fetch('/admin/bulk-action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    action: action,
                    ids: ids,
                    type: type
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Bulk action completed successfully!', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('Error performing bulk action!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error performing bulk action!', 'error');
            });
        }
    };

    // Toast Notification
    function showToast(message, type = 'info') {
        // You can implement a toast notification here
        // For now using alert
        alert(message);
    }

    // Image Preview
    const imageUrlInputs = document.querySelectorAll('input[type="url"]');
    imageUrlInputs.forEach(input => {
        input.addEventListener('blur', function() {
            // You can implement image preview logic here
        });
    });
});
</script>

<style>
/* Additional Styles */
.breadcrumb-arrow h4 {
    color: #333;
    font-weight: 600;
}

.card-header-tabs .nav-link {
    font-weight: 500;
}

.card-header-tabs .nav-link.active {
    font-weight: 600;
    border-bottom: 2px solid #0d6efd;
}

.table img {
    object-fit: cover;
}

.badge {
    font-size: 0.75em;
}

.form-check.form-switch {
    padding-left: 2.5em;
}

.sort-order {
    width: 70px;
}

/* Modal Styles */
.modal-header {
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.5rem;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    padding: 1rem 1.5rem;
}

/* Responsive Table */
.table-responsive {
    border-radius: 0.375rem;
}

/* Status Badges */
.bg-success-subtle {
    background-color: #d1e7dd !important;
}

.bg-secondary-subtle {
    background-color: #e2e3e5 !important;
}

/* Hover Effects */
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.025);
}

/* Button Group Styles */
.btn-group .btn {
    border-radius: 0.375rem;
}

/* Preview Styles */
.preview-box {
    border: 2px dashed #dee2e6;
    border-radius: 0.5rem;
    padding: 1rem;
    background: #f8f9fa;
}
</style>

@endsection