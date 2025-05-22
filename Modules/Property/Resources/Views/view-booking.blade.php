@extends('shared::layouts.master')

@section('title', 'View Booking')

@section('content')
<div class="container py-4" style="max-width: 540px;">

    <!-- Back Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('manage.bookings') }}" class="text-dark me-3"><i class="bi bi-arrow-left fs-5"></i></a>
        <h5 class="mb-0 fw-semibold">Make Payment</h5>
    </div>

    <!-- Property Card -->
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="d-flex">
        <img src="{{ asset('assets/images/property_images/' . ($property->images && $property->images->isNotEmpty() ? $property->images->first()->image_path : 'default-image.jpg')) }}" class="img-fluid rounded-start" style="width: 100px; height: 100px; object-fit: cover;" alt="Property Image">
            <div class="p-3">
                <h6 class="mb-1 fw-semibold">{{ $property->name }}</h6>
                <p class="text-muted small mb-1">🗺️ {{ $property->address }}</p>
                <div class="d-flex text-muted small">
                    <div class="me-3">🛁 {{ $property->pricings->isNotEmpty() ? optional($property->pricings->first())->unit['bathrooms'] ?? 'N/A' : 'N/A' }} Bathrooms</div>
                    <div>🛏️ {{ $property->pricings->isNotEmpty() ? optional($property->pricings->first())->unit['bedrooms'] ?? 'N/A' : 'N/A' }} Bedrooms</div>
                </div>
                <div class="fw-semibold mt-2 text-primary">₹{{ $property->pricings->isNotEmpty() ? optional($property->pricings->first())->pricing : 'N/A' }} <span class="fw-normal small">/ {{ $property->pricings->isNotEmpty() ? optional($property->pricings->first())->pricing_type : 'N/A' }}</span></div>
            </div>
        </div>
    </div>

    <form action="#" method="POST">
        @csrf
        <!-- Input Details -->
        <div class="bg-white p-3 mb-3 rounded-4 border">
            <div class="d-flex justify-content-between mb-2">
                <h6 class="fw-semibold mb-0">Your input details</h6>
            </div>
            <!-- Dates -->
            <div class="d-flex gap-3 mb-4">
                <div class="flex-fill">
                    <label class="form-label small">Check-in</label>
                    <input type="date" class="form-control shadow-sm search_booking_from" name="check_in" value="{{ $booking->check_in }}">
                    @error('check_in')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex-fill">
                    <label class="form-label small">Check-out</label>
                    <input type="date" class="form-control shadow-sm search_booking_to" name="check_out" value="{{ $booking->check_out }}">
                    @error('check_out')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Bedrooms -->
            <div class="mb-4">
                <label class="form-label small">Bedrooms</label>
                <div class="input-group w-50">
                    <button type="button" class="btn btn-outline-secondary" onclick="decrement('bedrooms', 0)">−</button>
                    <input type="text" id="bedrooms" class="form-control text-center search_bedrooms" name="bedrooms" value="{{ $booking->bedrooms }}" readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="increment('bedrooms')">+</button>
                </div>
                @error('bedrooms')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Adults -->
            <div class="mb-4">
                <label class="form-label small">Adults</label>
                <div class="input-group w-50">
                    <button type="button" class="btn btn-outline-secondary" onclick="decrement('adults', 0)">−</button>
                    <input type="text" id="adults" class="form-control text-center search_adults" name="adults" value="{{ $booking->adults }}" readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="increment('adults')">+</button>
                </div>
                @error('adults')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Children -->
            <div class="mb-4">
                <label class="form-label small">Children <span class="text-muted">(under 9 years)</span></label>
                <div class="input-group w-50">
                    <button type="button" class="btn btn-outline-secondary" onclick="decrement('children', 0)">−</button>
                    <input type="text" id="children" class="form-control text-center search_children" name="children" value="{{ $booking->children }}" readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="increment('children')">+</button>
                </div>
                @error('children')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Price Details -->
        <div class="bg-white p-3 mb-3 rounded-4 border">
            <h6 class="fw-semibold mb-3">Price details</h6>
            <div class="d-flex justify-content-between mb-2 text-muted small">
                <span class="stay_duration text-truncate">Stay Duration ({{ $booking->duration }})</span>
                <span class="stay_amount">₹{{ $booking->subtotal}}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 text-muted small">
                <span>Tax fee</span>
                <span class="tax_fee">₹{{ $booking->tax }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 text-muted small">
                <span>Coupon Discount</span>
                <span class="coupon_discount text-danger">₹{{ $booking->discount }}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-semibold">
                <span>Total price</span>
                <span class="total_amount">₹{{ $booking->total }}</span>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="bg-white p-3 mb-3 rounded-4 border">
            <h6 class="fw-semibold mb-3">Pay with</h6>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bi bi-credit-card-2-front me-2 fs-5 text-primary"></i>
                    <div>
                        <div class="fw-semibold">{{ $property->billing_method }}</div>
                        <!-- <div class="text-muted small">Visa, Mastercard & more</div> -->
                    </div>
                </div>
                <!-- <button class="btn btn-light btn-sm rounded-circle shadow-sm">
                    <i class="bi bi-plus"></i>
                </button> -->
            </div>
        </div>

        <!-- Global Coupons + Property Coupons -->
        @php
            use Modules\Property\Models\Coupon;

            $coupons = Coupon::whereDoesntHave('properties')->where('is_active', 1)->where('end_date', '>=', now())->get();
            $final_coupons = array_merge($coupons->toArray(), $property->coupons->toArray());
        @endphp
        <!--  end -->

        @if (isset($booking->status) && ($booking->status == 'pending' || $booking->status == 'cancelled'))
            <!-- Coupons Section -->
            <div class="bg-white p-3 mb-4 rounded-4 border shadow-sm">
                <h5 class="fw-bold mb-3">🎁 Coupons</h5>

                <!-- Coupon Input -->
                <div class="input-group mb-4 shadow-sm rounded-pill overflow-hidden">
                    <span class="input-group-text bg-white border-0 rounded-start-pill">
                        <i class="bi bi-ticket-perforated-fill text-danger"></i>
                    </span>
                    <input type="text" class="form-control border-0 shadow-none" placeholder="Enter Coupon Code..." name="code">
                    <button type="button" class="btn btn-outline-danger px-4 fw-semibold rounded-end-pill make_booking">APPLY</button>
                </div>

                <!-- Available Coupons (Side Scroll) -->
                <h6 class="fw-semibold mb-3">Available Offers</h6>
                <div class="d-flex overflow-auto flex-nowrap scroll-coupons">
                    @foreach ($final_coupons as $coupon)
                        <div class="glass-coupon-card p-4 rounded-4 text-white d-flex flex-column justify-content-between shadow-lg position-relative" style="min-width: 280px; backdrop-filter: blur(10px); background: linear-gradient(135deg, #ff6a00, #ee0979, #0acffe, #495aff); border: 1px solid rgba(255,255,255,0.1);">
                            
                            <div>
                                <!-- Header: Code Badge and Star Icon -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-danger px-3 py-1 rounded-pill text-uppercase">{{ $coupon['code'] }}</span>
                                    <i class="bi bi-stars fs-4 text-warning"></i>
                                </div>

                                <!-- Description -->
                                <p class="small text-white-50 mb-3">{{ $coupon['description'] }}</p>

                                <!-- Discount Display -->
                                @if ($coupon['type'] === 'percentage')
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="fs-4 fw-bold text-success">%{{ $coupon['value'] }}</span>
                                        <span class="text-white-50 small">OFF</span>
                                    </div>
                                @elseif ($coupon['type'] === 'amount')
                                    <div class="d-flex align-items-baseline gap-2">
                                        <span class="fs-4 fw-bold text-success">₹{{ number_format($coupon['value'], 2) }}</span>
                                        <span class="text-white-50 small">OFF</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Copy Button -->
                            <button 
                                type="button" 
                                class="btn btn-light text-danger fw-semibold rounded-pill px-4 btn-sm align-self-end d-flex align-items-center gap-2 mt-3"
                                onclick="copyCoupon('{{ $coupon['code'] }}', this)"
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="Copy"
                            >
                                <i class="bi bi-clipboard"></i> Copy
                            </button>

                            <!-- Optional Copied Tooltip (if using JS tooltip fallback) -->
                            <div class="copied-tooltip position-absolute bottom-0 end-0 mb-5 me-3 px-2 py-1 bg-dark text-white rounded small" style="display: none;">
                                Copied!
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif


        <!-- Make Payment Button -->
        <div class="d-grid">
            <button class="btn @if (isset($booking->status) && ($booking->status == 'pending' || $booking->status == 'cancelled')) btn-danger @else btn-success @endif btn-lg fw-semibold rounded-pill" 
                {{ isset($booking->status) && $booking->status == 'confirmed' ? 'disabled' : '' }}>
                @if (isset($booking->status))
                    @if ($booking->status == 'pending')
                        Make Payment
                    @elseif ($booking->status == 'cancelled')
                        ReBook
                    @else
                        Confirmed
                    @endif
                @endif
            </button>
        </div>
    </form>
</div>

<!-- Styles -->
<style>
    .glass-coupon-card {
        background: linear-gradient(135deg, rgba(255, 0, 102, 0.9), rgba(255, 102, 204, 0.85));
        backdrop-filter: blur(10px);
        color: white;
        min-height: 140px;
        position: relative;
    }

    .scroll-coupons {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE 10+ */
    }

    .scroll-coupons::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }

    .input-group .form-control::placeholder {
        color: #999;
        font-weight: 500;
    }

    .scroll-coupons {
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        cursor: grab;
    }

    .scroll-coupons.active {
        cursor: grabbing;
        user-select: none;
    }
    .copied-tooltip {
        font-size: 0.75rem;
        transition: all 0.3s ease-in-out;
        z-index: 10;
        pointer-events: none;
    }
</style>
@endsection 

@section('modals')
<!-- Invalid Coupon Modal -->
<div class="modal fade" id="invalidCouponModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow border-0">
      <div class="modal-body text-center p-4">
        <i class="bi bi-x-circle-fill text-danger fs-1 mb-3 d-block"></i>
        <h5 class="fw-bold text-danger mb-2">Invalid Coupon Code</h5>
        <p class="text-muted mb-0">The coupon code you entered is invalid, expired, or not applicable.</p>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollContainer = document.querySelector('.scroll-coupons');

        let isDown = false;
        let startX;
        let scrollLeft;

        let scrollDirection = 1;
        let isAutoScrolling = true;

        // Auto-scroll logic
        function autoScroll() {
            if (!scrollContainer || !isAutoScrolling) return;

            const maxScroll = scrollContainer.scrollWidth - scrollContainer.clientWidth;
            scrollContainer.scrollLeft += scrollDirection * 1.5;

            if (scrollContainer.scrollLeft >= maxScroll || scrollContainer.scrollLeft <= 0) {
                scrollDirection *= -1;
            }

            requestAnimationFrame(autoScroll);
        }

        // Pause auto scroll on interaction
        function pauseAutoScroll() {
            isAutoScrolling = false;
            clearTimeout(window.scrollPauseTimeout);
            window.scrollPauseTimeout = setTimeout(() => {
                isAutoScrolling = true;
                requestAnimationFrame(autoScroll);
            }, 3000);
        }

        // Mouse/touch dragging
        scrollContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            scrollContainer.classList.add('active');
            startX = e.pageX - scrollContainer.offsetLeft;
            scrollLeft = scrollContainer.scrollLeft;
            pauseAutoScroll();
        });

        scrollContainer.addEventListener('mouseleave', () => {
            isDown = false;
            scrollContainer.classList.remove('active');
        });

        scrollContainer.addEventListener('mouseup', () => {
            isDown = false;
            scrollContainer.classList.remove('active');
        });

        scrollContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - scrollContainer.offsetLeft;
            const walk = (x - startX) * 2; // scroll-fast multiplier
            scrollContainer.scrollLeft = scrollLeft - walk;
        });

        // Touch support
        scrollContainer.addEventListener('touchstart', pauseAutoScroll);

        requestAnimationFrame(autoScroll);
    });

    // Increment / Decrement Logic
    function increment(id) {
        const input = document.getElementById(id);
        input.value = parseInt(input.value) + 1;
    }

    function decrement(id, min) {
        const input = document.getElementById(id);
        const current = parseInt(input.value);
        if (current > min) input.value = current - 1;
    }
</script>

<script>
    // Jquery Scripts
    $(document).ready(function(){
        $(".make_booking").click(function(){
            var property_id = "{{ $property->id }}";
            var slug = "{{ $property->slug }}";
            var code = $('input[name="code"]').val();
            var check_in = $('input[name="check_in"]').val();
            var check_out = $('input[name="check_out"]').val();
            $.ajax({
                url: '{{ url('property') }}/' + slug + '/apply-coupon' , // Correct way
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    check_in: check_in,
                    check_out: check_out,
                    code: code
                },
                success: function (response) {
                    toastr.success(response.message);
                    $('.stay_duration').text('Stay Duration (' + response.stay.duration + ')');
                    $('.stay_amount').text('₹' + response.stay.amount);
                    $('.tax_fee').text('₹' + response.tax_fee);
                    $('.coupon_discount').text('₹' + response.coupon_discount);
                    $('.total_amount').text('₹' + response.total_amount);
                },
                error: function (xhr) {
                    console.log('error');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        if (errors.check_in) {
                            toastr.error(errors.check_in[0]);
                            // $('input[name="check_in"]').after('<div class="text-danger small mt-1">' + errors.check_in[0] + '</div>');
                        }

                        if (errors.check_out) {
                            toastr.error(errors.check_out[0]);
                            // $('input[name="check_out"]').after('<div class="text-danger small mt-1">' + errors.check_out[0] + '</div>');
                        }

                        if (errors.code) {
                            toastr.error(errors.code[0]);
                            // $('input[name="code"]').after('<div class="text-danger small mt-1">' + errors.code[0] + '</div>');
                            // Show and auto-close modal
                            // const modalEl = document.getElementById('invalidCouponModal');
                            // const invalidCouponModal = new bootstrap.Modal(modalEl);
                            // invalidCouponModal.show();

                            // setTimeout(() => {
                            //     bootstrap.Modal.getInstance(modalEl)?.hide();
                            // }, 2000);
                        }
                    }
                }
            });
        });
    });
</script>

<script>
    function copyCoupon(code, btn) {
        navigator.clipboard.writeText(code).then(() => {
            // Change icon and text temporarily
            btn.innerHTML = '<i class="bi bi-clipboard-check"></i> Copied!';
            btn.setAttribute('title', 'Copied!');
            
            // Show Bootstrap tooltip
            const tooltip = bootstrap.Tooltip.getInstance(btn) || new bootstrap.Tooltip(btn);
            tooltip.show();

            // Revert after 1.5 seconds
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-clipboard"></i> Copy';
                btn.setAttribute('title', 'Copy');
                tooltip.hide();
            }, 1500);
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltips.map(el => new bootstrap.Tooltip(el));
    });
</script>
@endsection