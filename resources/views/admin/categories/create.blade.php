<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
      @csrf
      
      <!-- Name -->
  <div class="row">
          <div class="mb-3 col-md-6">
        <label class="form-label">Name *</label>
        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
      </div>

      <!-- Slug -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Slug</label>
        <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" placeholder="auto-generates-if-empty">
        <div class="form-text">Leave empty to auto-generate from name</div>
      </div>

      <!-- Subtitle -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Subtitle</label>
        <input type="text" class="form-control" name="subtitle" value="{{ old('subtitle') }}">
      </div>

      <!-- Parent Category -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Parent Category</label>
        <select name="parent_id" class="form-select">
          <option value="">None (Main Category)</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Icon -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Icon</label>
        <div class="input-group">
          <select name="icon" id="iconSelect" class="form-select" style="font-family: 'Font Awesome 6 Free';">
            <option value="">Select Icon</option>
            @foreach($icons as $icon)
              <option value="{{ $icon }}" {{ old('icon') == $icon ? 'selected' : '' }}>
                {{ $icon }}
              </option>
            @endforeach
          </select>
          <span class="input-group-text" id="iconPreview">
            <i class="{{ old('icon') ? old('icon') : 'fa-solid fa-circle' }}"></i>
          </span>
        </div>
      </div>

      <!-- Description -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
      </div>

      <!-- Providers Count -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Providers Count</label>
        <input type="number" class="form-control" name="providers_count" value="{{ old('providers_count', 0) }}" min="0">
      </div>

      <!-- Tags -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Tags (comma separated)</label>
        <input type="text" class="form-control" name="tags" value="{{ old('tags') }}" placeholder="Daycare, Child-care, Preschool">
        <div class="form-text">Enter tags separated by commas</div>
      </div>

      <!-- Image URL -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Image URL</label>
        <input type="url" class="form-control" name="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/image.jpg">
      </div>

      <!-- Sort Order -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Sort Order</label>
        <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}">
      </div>

      <!-- Status -->
      <div class="mb-3 col-md-6">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" value="1" name="status" id="statusSwitch" {{ old('status', true) ? 'checked' : '' }}>
          <label class="form-check-label" for="statusSwitch">Active</label>
        </div>
      </div>
  </div>

      <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconSelect = document.getElementById('iconSelect');
    const iconPreview = document.getElementById('iconPreview').querySelector('i');

    iconSelect.addEventListener('change', function() {
        iconPreview.className = this.value || 'fa-solid fa-circle';
    });

    // Auto-generate slug from name
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    nameInput.addEventListener('blur', function() {
        if (!slugInput.value) {
            const slug = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
        }
    });
});
</script>