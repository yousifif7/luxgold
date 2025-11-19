@extends('layouts.admin')

@section('admin-title', 'Site Settings - Admin')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Site Settings</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5>Homepage Hero Defaults</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title Part 1</label>
                            <input type="text" name="title_part1" class="form-control" value="{{ $heroContent->title_part1 ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title Part 2</label>
                            <input type="text" name="title_part2" class="form-control" value="{{ $heroContent->title_part2 ?? '' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ $heroContent->description ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ $heroContent->meta_title ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meta Description</label>
                            <input type="text" name="meta_description" class="form-control" value="{{ $heroContent->meta_description ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CTA Text</label>
                            <input type="text" name="cta_text" class="form-control" value="{{ $heroContent->cta_text ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CTA URL</label>
                            <input type="url" name="cta_url" class="form-control" value="{{ $heroContent->cta_url ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Image Thumbnail URL</label>
                            <input type="url" name="hero_image_thumbnail" class="form-control" value="{{ $heroContent->hero_image_thumbnail ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hero Image Alt Text</label>
                            <input type="text" name="hero_alt_text" class="form-control" value="{{ $heroContent->hero_alt_text ?? '' }}">
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-primary">Save Settings</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
