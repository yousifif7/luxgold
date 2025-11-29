@extends('layouts.master')

@section('title', 'Locations - luxGold')
@section('content')
<section class="master-section">
    <div class="container">
        <h1 class="mt-4">Our Locations</h1>
        <p class="lead">luxGold currently operates in the following cities across Ireland. We're continually expanding — if your city isn't listed yet, enter your postcode and we'll notify you when we launch there.</p>

        <div class="row mt-3">
            <div class="col-md-8">
                <ul class="list-group">
                    @forelse($cities as $city)
                        <li class="list-group-item">{{ $city }}</li>
                    @empty
                        <li class="list-group-item">No cities seeded yet.</li>
                    @endforelse
                </ul>

                <p class="mt-3 text-muted">We work with local, Garda-vetted cleaners in each city, with regional managers ensuring quality and quick response times. For holiday lets and short-term rentals we offer dedicated turnover services with flexible scheduling.</p>
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Why luxGold in your city?</h5>
                    <ul>
                        <li>Vetted cleaners with verified reviews</li>
                        <li>Transparent pricing and easy booking</li>
                        <li>Local availability and fast support</li>
                    </ul>
                    <p class="mt-2">Want us to expand to your area? Use the contact form on the homepage to register interest — we prioritise cities with high demand.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
