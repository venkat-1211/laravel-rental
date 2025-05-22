<?php

namespace Modules\Property\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Http\Requests\AddCouponRequest;
use Modules\Property\Http\Requests\CouponToggleRequest;
use Modules\Property\Http\Requests\EditCouponRequest;
use Modules\Property\Models\Coupon;
use Modules\Property\Repositories\Interfaces\PropertyRepositoryInterface;
use Modules\Shared\Actions\HandleFormSubmission;

class CouponController extends Controller
{
    protected $propertyRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->propertyRepository->manageCoupons($request);
        }
        $properties = $this->propertyRepository->fetchProperties();

        return view('property::manage-coupons', compact('properties'));
    }

    public function addCoupon(AddCouponRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->addCoupon($request, $handler);
    }

    public function removeCouponProperty(Request $request, Coupon $coupon, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->removeCouponProperty($request, $coupon, $handler);
    }

    public function toggleCoupon(CouponToggleRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->toggleCoupon($request, $handler);
    }

    public function deleteCoupon(Coupon $coupon, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->deleteCoupon($coupon, $handler);
    }

    public function editCoupon(Coupon $coupon, EditCouponRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->editCoupon($coupon, $request, $handler);
    }
}
