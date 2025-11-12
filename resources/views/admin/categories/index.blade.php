@extends('layouts.admin')
@section('title','Categories')
@section('content')
<div class="page-wrapper">
  <div class="content">
    
    <div class="d-flex justify-content-between align-items-center mb-3">
       <div class="breadcrumb-arrow">
                <h4 class="mb-1">Categories</h4>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>                            
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
            </div>
      <a href="#" data-size="lg" data-url="{{ route('admin.categories.create') }}" data-ajax-popup="true"  data-title="{{__('Add Category')}}" class="btn btn-primary">Add Category</a>
    </div>
      <div class="card">
      <div class="card-body">
        <table class="table datatable">
          <thead><tr><th>Name</th><th>Slug</th><th>Services</th><th>Revenue</th><th></th></tr></thead>
          <tbody>
            @foreach($cats as $c)
            <tr>
              <td><i class="fa {{ $c->icon }}"></i> {{ $c->name }}</td>
              <td>{{ $c->slug }}</td>
              <td>{{ $stats[$c->id]['services_count'] ?? 0 }}</td>
              <td>{{ isset($stats[$c->id]) ? number_format($stats[$c->id]['revenue'],2) : '0.00' }}</td>
             <td class="text-end">
  <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="ti ti-dots-vertical"></i>
  </a>
  <ul class="dropdown-menu p-2">
    <li>
      <a href="#" 
         data-size="lg" 
         data-url="{{ route('admin.categories.edit', $c) }}" 
         data-ajax-popup="true"  
         data-title="{{ __('Edit Category') }}" 
         class="dropdown-item">
         <i class="ti ti-edit me-1"></i> Edit
      </a>
    </li>
    <li>
      <form action="{{ route('admin.categories.destroy', $c) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="dropdown-item text-danger">
          <i class="ti ti-trash me-1"></i> Delete
        </button>
      </form>
    </li>
  </ul>
</td>

          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-end">{{ $cats->links() }}</div>
    </div>
  </div>
</div>

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@endsection