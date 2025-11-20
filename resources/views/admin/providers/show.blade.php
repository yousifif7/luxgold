    <div class="modal-body">

    <h1 class="mb-4">Provider Details: {{ $provider->business_name }}</h1>

    <div class="card mb-4">
        <div class="card-header">Basic Information</div>
        <div class="card-body">
            <p><strong>Provider Name:</strong> {{ $provider->name }}</p>
            <p><strong>First Name:</strong> {{ $provider->user->first_name ?? '-' }}</p>
            <p><strong>Last Name:</strong> {{ $provider->user->last_name ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $provider->email }}</p>
            <p><strong>Phone:</strong> {{ $provider->phone }}</p>
            <p><strong>Business Name:</strong> {{ $provider->business_name }}</p>
            <p><strong>Category:</strong> {{ $provider->category->name ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($provider->status) }}</p>
            <p><strong>Featured:</strong> {{ $provider->is_featured ? 'Yes' : 'No' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Address</div>
        <div class="card-body">
            <p><strong>Physical Address:</strong> {{ $provider->physical_address }}</p>
            <p><strong>City:</strong> {{ $provider->city }}</p>
            <p><strong>State:</strong> {{ $provider->state }}</p>
            <p><strong>Zip Code:</strong> {{ $provider->zip_code }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Services & Programs</div>
        <div class="card-body">
            <p><strong>Service Description:</strong> {{ $provider->service_description }}</p>
            <p><strong>Sub Categories:</strong> 
                {{ $provider->sub_categories ? implode(', ', $provider->sub_categories) : '-' }}
            </p>
            <p><strong>Services Offered:</strong> 
                {{ $provider->services_offerd ? implode(', ', $provider->services_offerd) : '-' }}
            </p>
            <p><strong>Ages Served:</strong> {{ $provider->ages->name ?? '-' }}</p>
            <p><strong>Programs Offered:</strong> {{ $provider->programs_offered_id ? $provider->programs_offered->name ?? '-' : '-' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Pricing & Availability</div>
        <div class="card-body">
            <p><strong>Price Amount:</strong> {{ $provider->price_amount ?? '-' }}</p>
            <p><strong>Pricing Description:</strong> {{ $provider->pricing_description ?? '-' }}</p>
            <p><strong>Available Days:</strong> {{ $provider->available_days ? implode(', ', $provider->available_days) : '-' }}</p>
            <p><strong>Start Time:</strong> {{ $provider->start_time ?? '-' }}</p>
            <p><strong>End Time:</strong> {{ $provider->end_time ?? '-' }}</p>
            <p><strong>Availability Notes:</strong> {{ $provider->availability_notes ?? '-' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Licensing & Operation</div>
        <div class="card-body">
            <p><strong>License Number:</strong> {{ $provider->license_number ?? '-' }}</p>
            <p><strong>Years in Operation:</strong> {{ $provider->years_operation ?? '-' }}</p>
            <p><strong>Insurance Coverage:</strong> {{ $provider->insurance_coverage ?? '-' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Diversity & Special Features</div>
        <div class="card-body">
            <p><strong>Diversity Badges:</strong> 
                {{ $provider->diversity_badges ? implode(', ', $provider->diversity_badges) : '-' }}
            </p>
            <p><strong>Special Features:</strong> 
                {{ $provider->special_features ? implode(', ', $provider->special_features) : '-' }}
            </p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Website & Social Links</div>
        <div class="card-body">
            <p><strong>Website:</strong> <a href="{{ $provider->website }}" target="_blank">{{ $provider->website }}</a></p>
            <p><strong>Facebook:</strong> <a href="{{ $provider->facebook }}" target="_blank">{{ $provider->facebook }}</a></p>
            <p><strong>Instagram:</strong> <a href="{{ $provider->instagram }}" target="_blank">{{ $provider->instagram }}</a></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Media</div>
        <div class="card-body">
            <p><strong>Avatar:</strong></p>
            @if($provider->logo_path)
                <img src="{{ asset($provider->logo_path) }}" alt="Avatar" width="150">
            @else
                <span>No avatar uploaded</span>
            @endif

            <p class="mt-3"><strong>Facility Photos:</strong></p>
            @if($provider->facility_photos_paths)
                @foreach($provider->facility_photos_paths as $photo)
                    <img src="{{ asset($photo) }}" alt="Facility Photo" width="150" class="me-2 mb-2">
                @endforeach
            @else
                <span>No facility photos uploaded</span>
            @endif

            <p class="mt-3"><strong>License Documents:</strong></p>
            @if($provider->license_docs_paths)
                <ul>
                    @foreach($provider->license_docs_paths as $doc)
                        <li><a href="{{ asset($doc) }}" target="_blank">{{ basename($doc) }}</a></li>
                    @endforeach
                </ul>
            @else
                <span>No license documents uploaded</span>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Subscription</div>
        <div class="card-body">
            <p><strong>Plan Name:</strong> {{ $provider->subscription->plan->name ?? '-' }}</p>
            <p><strong>Amount:</strong> ${{ number_format($provider->subscription->amount ?? 0, 2) }}</p>
            <p><strong>Status:</strong> {{ $provider->subscription->status ?? '-' }}</p>
            <p><strong>Start Date:</strong> {{ $provider->subscription->started_at ?? '-' }}</p>
            <p><strong>Renewal Date:</strong> {{ $provider->subscription->renews_at ?? '-' }}</p>
        </div>
    </div>
</div>