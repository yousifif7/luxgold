

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Name -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="auto-generates-if-empty">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave empty to auto-generate from name</div>
                        </div>

                        <!-- Subtitle -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Subtitle</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" name="subtitle" value="{{ old('subtitle', $category->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Parent Category -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Parent Category</label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">None (Main Category)</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Icon -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Icon</label>
                            <div class="input-group">
                                <select name="icon" id="iconSelect" class="form-select @error('icon') is-invalid @enderror" style="font-family: 'Font Awesome 6 Free';">
                                    <option value="">Select Icon</option>
                                    @foreach($icons as $icon)
                                        <option value="{{ $icon }}" {{ old('icon', $category->icon) == $icon ? 'selected' : '' }}>
                                            {{ $icon }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="input-group-text" id="iconPreview">
                                    <i class="{{ $category->icon ? $category->icon : 'fa-solid fa-circle' }}"></i>
                                </span>
                            </div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Providers Count -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Providers Count</label>
                            <input type="number" class="form-control @error('providers_count') is-invalid @enderror" name="providers_count" value="{{ old('providers_count', $category->providers_count) }}" min="0">
                            @error('providers_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tags (comma separated)</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" name="tags" value="{{ old('tags', $category->tags ? implode(', ', $category->tags) : '') }}" placeholder="Daycare, Child-care, Preschool">
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter tags separated by commas</div>
                        </div>

                        <!-- Image URL -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Image URL</label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror" name="image_url" value="{{ old('image_url', $category->image_url) }}" placeholder="https://example.com/image.jpg">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($category->image_url)
                                <div class="mt-2">
                                    <small class="text-muted">Current Image:</small>
                                    <img src="{{ $category->image_url }}" alt="Category Image" class="img-thumbnail mt-1" style="max-height: 80px;">
                                </div>
                            @endif
                        </div>

                        <!-- Sort Order -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3 col-md-6">
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" value="1" name="status" id="statusSwitch" {{ old('status', $category->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusSwitch">Active Category</label>
                            </div>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3 col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i> Update Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
                            <i class="ti ti-x me-1"></i> Cancel
                        </a>
                        
                    </div>
                </form>
            </div>
        </div>
