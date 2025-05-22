<?php

namespace Modules\Nearby\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Nearby\Http\Requests\AddPropertyNearbyRequest;
use Modules\Nearby\Http\Requests\NearbyToggleRequest;
use Modules\Nearby\Repositories\Interfaces\NearbyRepositoryInterface;
use Modules\Property\Models\Property;
use Modules\Shared\Actions\HandleFormSubmission;

class NearbyController extends Controller
{
    protected $nearbyRepository;

    public function __construct(NearbyRepositoryInterface $nearbyRepository)
    {
        $this->nearbyRepository = $nearbyRepository;
    }

    public function propertyNearbies(Request $request, Property $property)
    {
        if ($request->ajax()) {
            return $this->nearbyRepository->propertyNearbies($request, $property->id);
        }

        return view('nearby::property-nearbies', compact('property'));
    }

    public function addPropertyNearby(AddPropertyNearbyRequest $request, Property $property, HandleFormSubmission $handler)
    {
        return $this->nearbyRepository->addPropertyNearby($request, $property, $handler);
    }

    public function toggleNearby(NearbyToggleRequest $request, HandleFormSubmission $handler)
    {
        return $this->nearbyRepository->toggleNearby($request, $handler);
    }

    public function deletePropertyNearby(Property $property, $id, HandleFormSubmission $handler)
    {
        return $this->nearbyRepository->deletePropertyNearby($property, $id, $handler);
    }
}
