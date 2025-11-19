@extends('layouts.admin')

@section('admin-title', 'Promotions - Admin')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Promotions</h4>
            <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">Add Promotion</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Active</th>
                                <th>Show on Homepage</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promotions as $promo)
                            <tr>
                                <td>{{ $promo->title }}</td>
                                <td>{{ $promo->is_active ? 'Yes' : 'No' }}</td>
                                <td>{{ $promo->show_on_homepage ? 'Yes' : 'No' }}</td>
                                <td>{{ $promo->start_at?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $promo->end_at?->format('Y-m-d') ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
