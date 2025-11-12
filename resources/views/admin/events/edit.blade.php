<form id="editEventForm" action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body pb-0">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Event Title <span class="text-danger">*</span></label>
                    <input name="title" type="text" class="form-control" placeholder="Enter event title" value="{{ old('title', $event->title) }}" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Subtitle</label>
                    <input name="subtitle" type="text" class="form-control" placeholder="Enter event subtitle" value="{{ old('subtitle', $event->subtitle) }}">
                </div>
            </div>
             <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if($category->id==$event->category) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if(Auth::user()->hasRole('admin'))


            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Provider</label>
                    <select name="provider_id" class="form-control" required>
                        <option value="">Select Provider</option>
                        @foreach ($providers as $provider)
                        <option value="{{ $provider->id }}" @if($provider->id==$event->provider_id) selected @endif>{{ $provider->first_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input name="start_date" type="datetime-local" class="form-control" value="{{ old('start_date', $event->start_date ? $event->start_date->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input name="end_date" type="datetime-local" class="form-control" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input name="location" type="text" class="form-control" placeholder="Enter location" value="{{ old('location', $event->location) }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input name="city" type="text" class="form-control" placeholder="Enter city" value="{{ old('city', $event->city) }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Cost</label>
                    <input name="cost" type="number" step="0.01" class="form-control" placeholder="0.00" value="{{ old('cost', $event->cost) }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Max Capacity</label>
                    <input name="max_capacity" type="number" class="form-control" placeholder="Enter maximum capacity" value="{{ old('max_capacity', $event->max_capacity) }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Age Group</label>
                    <input name="age_group" type="text" class="form-control" placeholder="e.g., 18+, All Ages" value="{{ old('age_group', $event->age_group) }}">
                </div>
            </div>
                        @if(Auth::user()->hasRole('admin'))

            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ old('status', $event->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            @endif
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Published At</label>
                    <input name="published_at" type="datetime-local" class="form-control" value="{{ old('published_at', $event->published_at ? $event->published_at->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input name="author" type="text" class="form-control" placeholder="Enter author name" value="{{ old('author', $event->author) }}">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">Image URL</label>
                    <input name="image_url" type="file" class="form-control" placeholder="Enter image URL" value="{{ old('image_url', $event->image_url) }}">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter event description">{{ old('description', $event->description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer d-flex align-items-center gap-1">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Event</button>
    </div>
</form>