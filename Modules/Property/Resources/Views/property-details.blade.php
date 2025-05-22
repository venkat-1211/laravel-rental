@extends('shared::layouts.master')

@section('title', 'Property Details')

@section('styles')
<style>
    .carousel-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #ccc;
        margin: 0 4px;
    }

    .carousel-indicators .active {
        background-color: #dc3545;
    }

    .facility-badge {
        transition: all 0.2s ease;
    }

    .facility-badge:hover {
        transform: scale(1.05);
        background-color: #f8f9fa;
    }

    .testimonial-box {
        border-left: 4px solid #dc3545;
        background-color: #fff;
        transition: box-shadow 0.3s;
    }

    .testimonial-box:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .custom-button {
        border-radius: 25px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
        transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
    }

    .custom-button:hover {
        background-color: #0056b3; /* Darker shade on hover */
        transform: translateY(-2px); /* Slight lift effect */
    }
</style>
@endsection

@section('content')
<div class="container py-4">

    <!-- Back Button -->
    <div class="mb-3 text-end">
    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg custom-button">
        <i class="bi bi-arrow-left-circle-fill"></i> Back to Listings
    </a>
</div>

    <!-- Carousel -->
    <div id="propertyCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow">
            @foreach ($property->images as $index => $image)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('assets/images/property_images/' . $image->image_path) }}" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Property Image {{ $index + 1 }}">
                </div>
            @endforeach
        </div>

        <!-- Dots -->
        <div class="carousel-indicators">
            @foreach ($property->images as $index => $image)
                <button type="button" data-bs-target="#propertyCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Property Info -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark">{{ $property->name }}</h2>
        <p class="text-muted mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $property->address }}</p>
        <div class="d-flex flex-wrap gap-3 text-secondary fs-6">
            <span><i class="bi bi-house-door"></i> {{ optional(optional($property->pricings->first())->unit)['bedrooms'] ?? 'N/A' }} Bedroom</span>
            <span><i class="bi bi-droplet"></i> {{ optional(optional($property->pricings->first())->unit)['bathrooms'] ?? 'N/A' }} Bathroom</span>
        </div>
    </div>

    <!-- Owner Info -->
    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded shadow-sm mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ $property->user->profile->profile_image }}" class="rounded-circle" width="55" height="55" alt="Owner">
            <div>
                <h6 class="mb-0">{{ $property->user->name }}</h6>
                <small class="text-muted">Property Owner</small>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="tel:{{ $property->user->profile->phone }}" class="btn btn-outline-danger rounded-circle" title="Call Owner"><i class="bi bi-telephone-fill"></i></a>
            <a href="mailto:{{ $property->user->email }}" class="btn btn-outline-primary rounded-circle" title="Email Owner"><i class="bi bi-envelope-fill"></i></a>
        </div>
    </div>

    <!-- Map -->
    <div class="mb-4">
        <h5 class="fw-bold">Location</h5>
        <div class="rounded shadow overflow-hidden" style="height: 50vh;">
            <iframe src="https://maps.google.com/maps?q={{ urlencode($property->address) }}&output=embed" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>

    <!-- Amenities -->
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Home Facilities</h5>
        <div class="d-flex flex-wrap gap-3">
            @foreach ($property->amenities as $amenity)
                <div class="facility-badge bg-light rounded px-3 py-2 shadow-sm d-flex align-items-center gap-2">
                    <img src="{{ asset('assets/images/amenities/' . $amenity->icon) }}" width="20" height="20" alt=""> {{ $amenity->name }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- Description -->
    <div class="mb-4">
        <h5 class="fw-bold mb-2">Property Description</h5>
        <p class="text-muted lh-lg">{{ $property->description }}</p>
    </div>

    <!-- Testimonials -->
    @if($property->testimonials->isNotEmpty())
        <div class="mb-5">
            <h5 class="fw-bold mb-3">Testimonials</h5>
            @foreach($property->testimonials as $index => $testimonial)
                <div class="testimonial-box p-3 rounded shadow-sm mb-3 review-item" style="{{ $index >= 3 ? 'display: none;' : '' }}">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <img src="{{ $testimonial->user->profile->profile_image }}" class="rounded-circle" width="45" height="45" alt="User">
                        <div>
                            <strong>{{ $testimonial->user->name }}</strong><br>
                            <div class="text-warning">
                                @for ($i = 0; $i < $testimonial->ratings; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 text-muted fst-italic">{{ $testimonial->description }}</p>
                </div>
            @endforeach
            <!-- Load More Button -->
            <div class="text-center mt-4">
                <button id="loadMoreBtn" class="btn btn-warning px-4">View More Testimonials ...</button>
            </div>
        </div>
    @else
        <h5 class="fw-bold mb-3">Testimonials</h5>
        <div class="alert alert-info shadow-sm mb-5">
            <i class="bi bi-info-circle-fill me-2"></i> No testimonials found for this property.
        </div>
    @endif

    <!-- Pricing and Booking -->
    <div class="d-flex justify-content-between align-items-center p-4 bg-light rounded shadow mb-5">
        <div>
            <h4 class="text-danger fw-bold mb-0">
                ₹ {{ optional($property->pricings->first())->pricing ?? 'N/A' }} /
                <small class="text-muted">{{ optional($property->pricings->first())->pricing_type ?? 'N/A' }}</small>
            </h4>
        </div>
        <a href="{{ route('make.booking', $property->slug)}}" class="btn btn-danger btn-lg px-4">Book Now</a>
    </div>

</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const propertyItems = document.querySelectorAll('.review-item');
    let visibleCount = 3; // First 3 items shown

      // Hide the button if items are less than or equal to visibleCount
      if (propertyItems.length <= visibleCount) {
        loadMoreBtn.style.display = 'none';
      }

      propertyItems.forEach((item, index) => {
        item.style.display = index < visibleCount ? 'block' : 'none';
      });

    loadMoreBtn.addEventListener('click', function () {
      visibleCount += 6; // Increase by 6 each click

      propertyItems.forEach((item, index) => {
        if (index < visibleCount) {
          item.style.display = 'block';
        }
      });

      // Hide button if all properties are visible
      if (visibleCount >= propertyItems.length) {
        loadMoreBtn.style.display = 'none';
      }
    });
  });
</script>
@endsection
