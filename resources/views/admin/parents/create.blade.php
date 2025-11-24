           <form method="POST" action="{{ route('admin.customers.store') }}">
          @csrf
          <div class="modal-body pb-0">
  @csrf
  <div class="mb-3"><label>First Name</label><input class="form-control" name="first_name" value="{{ old('first_name') }}" required></div>
    <div class="mb-3"><label>Last Name</label><input class="form-control" name="last_name" value="{{ old('last_name') }}" required></div>

  <div class="mb-3"><label>Email</label><input class="form-control" name="email" type="email" value="{{ old('email') }}" required></div>
  <div class="mb-3"><label>Password</label><input class="form-control" name="password" type="password" required></div>
  <div class="mb-3"><label>Confirm Password</label><input class="form-control" name="password_confirmation" type="password" required></div>
  <div class="mb-3"><label>City</label><input class="form-control" name="city" value="{{ old('city') }}"></div>
  <div class="mb-3"><label>Status</label>
    <select name="status" class="form-control"><option value="active">Active</option><option value="inactive">Inactive</option><option value="pending">Pending</option></select>
  </div>
          </div>
          <div class="modal-footer d-flex align-items-center gap-1">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Parent</button>
          </div>
        </form>