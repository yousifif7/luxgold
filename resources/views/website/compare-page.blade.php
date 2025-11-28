@extends('layouts.master')

@section('title', 'Compare - luxGold')
@section('content')
<section class="master-section">
    <div class="container">
        <h1 class="mt-4">
          Compare cleaning services side by side <br> find the right cleaner for your space.
        </h1>
        <div class="search-box col-md-7 mx-auto">
            <form action="{{ route('website.find-cleaner') }}"  class="row g-2">
                <div class="col-md-6">
                    <div class="input-group-div">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" placeholder="What service do you need?">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group-div green">
                        <i class="bi bi-geo-alt "></i>
                        <input type="text" name="location" placeholder="Where do you need?">
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="search-provider_btn">  
                    <i class="bi bi-lightning-charge-fill me-1"></i> Search Cleaners
                  </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="comparision-section">
    <div class="container mb-5 mt-5">
        <div class="table-responsive">
            <table class="comparison table">
                <thead>
                  <tr>
                    <th>Features</th>
                    @foreach($providers as $index => $provider)
                    <th>Cleaner {{ $index + 1 }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Logo & Name</td>
                    @foreach($providers as $provider)
                    <td>
                      <div class="provider-logo">
                          <img src="{{ asset($provider->logo_path ?? 'assets/images/updated-logo.jpeg') }}" alt="{{ $provider->name }}">
                      </div>
                      <div>{{ $provider->name }}</div>
                    </td>
                    @endforeach
                  </tr>
                  <tr>
                    <td>Category</td>
                    @foreach($providers as $provider)
                    <td data-label="Category">{{ $provider->category->name }}</td>
                    @endforeach
                  </tr>
                  <tr>
                    <td>Service Categories</td>
                    @foreach($providers as $provider)
                    <td data-label="Service Categories">
                        @php
                            $categories = $provider->service_categories ?? [];
                        @endphp
                        {{ implode(', ', $categories) }}
                    </td>
                    @endforeach
                  </tr>
                  <tr>
                    <td>Location</td>
                    @foreach($providers as $provider)
                    <td data-label="Location">{{ $provider->city }}, {{ $provider->state }}</td>
                    @endforeach
                  </tr>
                  <tr>
                    <td>Hours</td>
                    @foreach($providers as $provider)
                    <td data-label="Hours">
                        {{ date('g:i A', strtotime($provider->start_time)) }} – {{ date('g:i A', strtotime($provider->end_time)) }}
                    </td>
                    @endforeach
                  </tr>
                  <tr>
                    <td>Available Days</td>
                    @foreach($providers as $provider)
                    <td data-label="Available Days">
                        @php
                            $days = $provider->available_days ?? [];
                            $dayNames = array_map('ucfirst', $days);
                        @endphp
                        {{ implode(', ', $dayNames) }}
                    </td>
                    @endforeach
                  </tr>
                  <tr>
                    <td>Special Features</td>
                    @foreach($providers as $provider)
                    <td data-label="Special Features">
                        @php
                            $features = $provider->special_features ?? [];
                            $formattedFeatures = array_map(function($feature) {
                                return str_replace('_', ' ', ucfirst($feature));
                            }, $features);
                        @endphp
                        {{ implode(', ', $formattedFeatures) }}
                    </td>
                    @endforeach
                  </tr>
                  <tr>
                    <td>Pricing</td>
                    @foreach($providers as $provider)
                    <td data-label="Pricing">
                        ${{ number_format($provider->price_amount, 2) }}<br>
                        <small>{{ $provider->pricing_description }}</small>
                    </td>
                    @endforeach
                  </tr>
                  {{-- Years, License, Diversity removed from public comparison per product decision --}}
                  <tr>
                    <td>Contact</td>
                    @foreach($providers as $provider)
                    <td data-label="Contact">
                        {{ $provider->phone_number }}<br>
                        {{ $provider->email }}
                    </td>
                    @endforeach
                  </tr>
                  <tr>
                    <td>Profile Performance</td>
                    @foreach($providers as $provider)
                    <td data-label="Profile Performance">
                        Views: {{ $provider->totalView() }}<br>
                        Inquiries: {{ $provider->totalInquiries() }}
                    </td>
                    @endforeach
                  </tr>
                  
                </tbody>
              </table>
        </div>
    </div>
</section>
@endsection