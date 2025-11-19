@extends('layouts.admin')

@section('admin-title', 'Create Promotion - Admin')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Create Promotion</h4>
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.promotions.store') }}" method="POST">
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image URL</label>
                            <input type="url" name="image_url" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link URL</label>
                            <input type="url" name="link_url" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_at" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_at" class="form-control">
                        </div>
                        <div class="col-md-6 form-check form-switch mt-3">
                            {{-- include a hidden field so unchecked boxes submit 0 --}}
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="col-md-6 form-check form-switch mt-3">
                            <input type="hidden" name="show_on_homepage" value="0">
                            <input type="checkbox" name="show_on_homepage" class="form-check-input" value="1">
                            <label class="form-check-label">Show on Homepage</label>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary">Create Promotion</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
