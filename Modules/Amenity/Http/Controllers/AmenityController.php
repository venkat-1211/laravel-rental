<?php

namespace Modules\Amenity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Amenity\Http\Requests\AddAmenityRequest;
use Modules\Amenity\Http\Requests\AddPropertyAmenityRequest;
use Modules\Amenity\Http\Requests\AmenityToggleRequest;
use Modules\Amenity\Http\Requests\EditAmenityRequest;
use Modules\Amenity\Repositories\Interfaces\AmenityRepositoryInterface;
use Modules\Property\Models\Property;
use Modules\Shared\Actions\HandleFormSubmission;

class AmenityController extends Controller
{
    protected $amenityRepository;

    public function __construct(AmenityRepositoryInterface $amenityRepository)
    {
        $this->amenityRepository = $amenityRepository;
    }

    public function manageAmenties(Request $request)
    {
        if ($request->ajax()) {
            return $this->amenityRepository->manageAmenities($request);
        }

        return view('amenity::manage-amenties');
    }

    public function addAmenity(AddAmenityRequest $request, HandleFormSubmission $handler)
    {
        return $this->amenityRepository->addAmenity($request, $handler);
    }

    public function editAmenity(EditAmenityRequest $request, HandleFormSubmission $handler, $id)
    {
        return $this->amenityRepository->editAmenity($request, $handler, $id);
    }

    public function toggleAmenity(AmenityToggleRequest $request, HandleFormSubmission $handler)
    {
        return $this->amenityRepository->toggleAmenity($request, $handler);
    }

    public function deleteAmenity($id)
    {
        return $this->amenityRepository->deleteAmenity($id);
    }

    public function propertyAmenities(Property $property, Request $request)
    {
        $amenities = $this->amenityRepository->fetchAllAmenities();
        if ($request->ajax()) {
            return $this->amenityRepository->propertyAmenities($request, $property->id);
        }

        return view('amenity::property-amenity', compact('property', 'amenities'));
    }

    public function deletePropertyAmenity(Property $property, $id, HandleFormSubmission $handler)
    {
        return $this->amenityRepository->deletePropertyAmenity($property, $id, $handler);
    }

    public function addPropertyAmenity(Property $property, AddPropertyAmenityRequest $request, HandleFormSubmission $handler)
    {
        return $this->amenityRepository->addPropertyAmenity($property, $request, $handler);
    }
}
