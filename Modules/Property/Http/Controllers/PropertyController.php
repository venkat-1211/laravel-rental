<?php

namespace Modules\Property\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Amenity\Repositories\Interfaces\AmenityRepositoryInterface;
use Modules\Property\Http\Requests\AddPropertyImageRequest;
use Modules\Property\Http\Requests\AddPropertyRequest;
use Modules\Property\Http\Requests\EditPropertyRequest;
use Modules\Property\Models\Property;
use Modules\Property\Models\PropertyImage;
use Modules\Property\Repositories\Interfaces\PropertyRepositoryInterface;
use Modules\Shared\Actions\HandleFormSubmission;

class PropertyController extends Controller
{
    protected $propertyRepository;

    protected $amenityRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository, AmenityRepositoryInterface $amenityRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->amenityRepository = $amenityRepository;
    }

    public function index()
    {
        return view('property::index');
    }

    public function manageProperties(Request $request)
    {

        if ($request->ajax()) {
            return $this->propertyRepository->manageProperties($request);
        }

        $property_types = $this->propertyRepository->allPropertyTypes();
        $amenities = $this->amenityRepository->fetchAllActiveAmenities();

        return view('property::manage-properties', compact('property_types', 'amenities'));
    }

    public function addProperty(AddPropertyRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->addProperty($request, $handler);
    }

    public function editProperty(Property $property, EditPropertyRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->editProperty($property, $request, $handler);
    }

    public function deleteProperty(Property $property, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->deleteProperty($property, $handler);
    }

    public function PropertyRemoveImage(PropertyImage $propertyImage, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->PropertyRemoveImage($propertyImage, $handler);
    }

    // Property Images
    public function propertyImages(Property $property, Request $request)
    {
        if (request()->ajax()) {
            return $this->propertyRepository->propertyImages($request, $property->id);
        }

        return view('property::property-images', compact('property'));
    }

    public function deletePropertyImage(Property $property, $id, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->deletePropertyImage($property, $id, $handler);
    }

    public function addPropertyImage(Property $property, AddPropertyImageRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->addPropertyImage($property, $request, $handler);
    }

    public function propertyDetails(Property $property)
    {
        return view('property::property-details', compact('property'));
    }
}
