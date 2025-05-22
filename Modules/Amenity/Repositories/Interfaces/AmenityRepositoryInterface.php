<?php

namespace Modules\Amenity\Repositories\Interfaces;

interface AmenityRepositoryInterface
{
    public function manageAmenities($request);

    public function fetchAmenities();

    public function fetchAllAmenities();

    public function addAmenity($request, $handler);

    public function editAmenity($request, $handler, $id);

    public function amenitySole($id);

    public function amenityImage($id);

    public function toggleAmenity($request, $handler);

    public function deleteAmenity($id);

    public function addPropertyAmenityAdd($request, $handler);

    public function propertyAmenities($request, $propertyId);

    public function fetchPropertyAmenities($propertyId);

    public function deletePropertyAmenity($property, $amenityId, $handler);
}
