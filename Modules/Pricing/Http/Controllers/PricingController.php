<?php

namespace Modules\Pricing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Pricing\Http\Requests\AddPropertyPricingRequest;
use Modules\Pricing\Http\Requests\EditPropertyPricingRequest;
use Modules\Pricing\Http\Requests\PricingToggleRequest;
use Modules\Pricing\Models\Pricing;
use Modules\Pricing\Repositories\Interfaces\PricingRepositoryInterface;
use Modules\Property\Models\Property;
use Modules\Shared\Actions\HandleFormSubmission;

class PricingController extends Controller
{
    protected $pricingRepository;

    public function __construct(PricingRepositoryInterface $pricingRepository)
    {
        $this->pricingRepository = $pricingRepository;
    }

    public function propertyPricings(Request $request, Property $property)
    {
        if ($request->ajax()) {
            return $this->pricingRepository->propertyPricings($request, $property->id);
        }

        return view('pricing::property-pricings', compact('property'));
    }

    public function addPropertyPricing(AddPropertyPricingRequest $request, Property $property, HandleFormSubmission $handler)
    {
        return $this->pricingRepository->addPropertyPricing($request, $property, $handler);
    }

    public function editPropertyPricing(EditPropertyPricingRequest $request, HandleFormSubmission $handler, Pricing $pricing)
    {
        return $this->pricingRepository->editPropertyPricing($request, $handler, $pricing);
    }

    public function togglePricing(PricingToggleRequest $request, HandleFormSubmission $handler)
    {
        return $this->pricingRepository->togglePricing($request, $handler);
    }

    public function deletePropertyPricing(Property $property, $id, HandleFormSubmission $handler)
    {
        return $this->pricingRepository->deletePropertyPricing($property, $id, $handler);
    }
}
