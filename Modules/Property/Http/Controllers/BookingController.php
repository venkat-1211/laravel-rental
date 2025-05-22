<?php

namespace Modules\Property\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Http\Requests\ApplyCouponRequest;
use Modules\Property\Models\Property;
use Modules\Property\Repositories\PropertyRepository;
use Modules\Property\Models\Booking;

class BookingController extends Controller
{
    protected $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function makeBooking(Property $property)
    {
        return view('property::make-booking', compact('property'));
    }

    public function manageBookings(Request $request)
    {
        $allBookings = $this->propertyRepository->allBookings($request);

        return view('property::manage-bookings', compact('allBookings'));
    }

    public function applyCoupon(Property $property, ApplyCouponRequest $request)
    {
        return $this->propertyRepository->applyCoupon($request, $property);
    }

    public function viewBooking(Property $property, Booking $booking)
    {
        return view('property::view-booking', compact('property', 'booking'));
    }
}
