@extends('layouts.master')

@section('title', 'Services - luxGold')
@section('content')
<section class="master-section">
    <div class="container">
        <h1 class="mt-4">Services We Provide</h1>
        <p class="lead">Discover the range of cleaning services offered by luxGold cleaners. Prices are indicative starting points—final quotes depend on property size and special requirements.</p>

        <div class="row gy-4 mt-3">
            <div class="col-md-6">
                <div class="card p-3">
                    <h4>Regular Home Clean</h4>
                    <p class="mb-1">A routine clean covering bathrooms, kitchen, living areas and bedrooms.</p>
                    <p class="text-muted mb-0"><strong>Typical from:</strong> 35 per hour (1 cleaner)</p>
                    <ul class="mt-2">
                        <li>Dusting and vacuuming</li>
                        <li>Kitchen surface and sink cleaning</li>
                        <li>Bathroom sanitation</li>
                        <li>Light tidying</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3">
                    <h4>Deep Clean</h4>
                    <p class="mb-1">An intensive clean focusing on neglected areas: skirting boards, behind appliances, descaling and heavy-duty surface cleaning.</p>
                    <p class="text-muted mb-0"><strong>Typical from:</strong> 70 fixed (small flat) or 45 per hour</p>
                    <ul class="mt-2">
                        <li>Full kitchen and bathroom deep clean</li>
                        <li>Baseboards, doors, and window sills</li>
                        <li>Appliance exterior cleaning (oven add-on available)</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3">
                    <h4>End-of-Tenancy / Move-Out Clean</h4>
                    <p class="mb-1">Designed to meet landlord and letting agent expectations to help secure deposits.</p>
                    <p class="text-muted mb-0"><strong>Typical from:</strong> 120 (small property) depending on condition</p>
                    <ul class="mt-2">
                        <li>Full deep clean of all rooms</li>
                        <li>Oven and appliance cleaning (optional add-on)</li>
                        <li>Carpet spot cleaning</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3">
                    <h4>Oven & Appliance Cleaning</h4>
                    <p class="mb-1">Professional oven cleaning using safe degreasers and hand finishing.</p>
                    <p class="text-muted mb-0"><strong>Typical from:</strong> 40 per oven</p>
                    <ul class="mt-2">
                        <li>Interior oven degrease</li>
                        <li>Removable trays and racks cleaned</li>
                        <li>Exterior wipe down and polish</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3">
                    <h4>Carpet Cleaning (Steam)</h4>
                    <p class="mb-1">Hot water extraction for carpets and rugs to remove stains and allergens.</p>
                    <p class="text-muted mb-0"><strong>Typical from:</strong> 30 per room (subject to inspection)</p>
                    <ul class="mt-2">
                        <li>Pre-treatment and stain removal</li>
                        <li>Hot water extraction/steam cleaning</li>
                        <li>Drying guidance and follow-up advice</li>
                    </ul>
                </div>
            </div>

            <div class="col-12 text-center mt-4">
                <p class="text-muted">For exact pricing and availability, enter your postcode or city on the homepage and request a quote. Additional charges may apply for hoarding, heavy staining, or specialist cleaning.</p>
            </div>
        </div>

    </div>
</section>
@endsection
