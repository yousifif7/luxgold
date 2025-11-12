<form id="addEventForm" action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body pb-0">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Event Title <span class="text-danger">*</span></label>
                    <input name="title" type="text" class="form-control" placeholder="Enter event title" required>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Subtitle</label>
                    <input name="subtitle" type="text" class="form-control" placeholder="Enter event subtitle">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                        <option value="{{ $provider->id }}">{{ $provider->first_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input name="start_date" type="datetime-local" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input name="end_date" type="datetime-local" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input name="location" type="text" class="form-control" placeholder="Enter location">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input name="city" type="text" class="form-control" placeholder="Enter city">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Cost</label>
                    <input name="cost" type="number" step="0.01" class="form-control" placeholder="0.00">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Max Capacity</label>
                    <input name="max_capacity" type="number" class="form-control" placeholder="Enter maximum capacity">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Age Group</label>
                    <input name="age_group" type="text" class="form-control" placeholder="e.g., 18+, All Ages">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Published At</label>
                    <input name="published_at" type="datetime-local" class="form-control">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <input name="author" type="text" class="form-control" placeholder="Enter author name">
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">Image URL</label>
                    <input name="image_url" type="file" class="form-control" placeholder="Enter image URL">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter event description"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer d-flex align-items-center gap-1">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Event</button>
    </div>
</form>