<?php

namespace Modules\Property\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Http\Requests\addSpecialDayRequest;
use Modules\Property\Http\Requests\EditSpecialDayRequest;
use Modules\Property\Http\Requests\SpecialDayToggleRequest;
use Modules\Property\Models\SpecialDay;
use Modules\Property\Repositories\Interfaces\PropertyRepositoryInterface;
use Modules\Shared\Actions\HandleFormSubmission;

class SpecialDayController extends Controller
{
    protected $propertyRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            return $this->propertyRepository->manageSpecialDays();
        }
        $properties = $this->propertyRepository->fetchProperties();

        return view('property::manage-special-days', compact('properties'));
    }

    public function addSpecialDay(addSpecialDayRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->addSpecialDay($request, $handler);
    }

    public function toggleSpecialDay(SpecialDayToggleRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->toggleSpecialDay($request, $handler);
    }

    public function deleteSpecialDay($id, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->deleteSpecialDay($id, $handler);
    }

    public function editSpecialDay(SpecialDay $specialDay, EditSpecialDayRequest $request, HandleFormSubmission $handler)
    {
        return $this->propertyRepository->editSpecialDay($specialDay, $request, $handler);
    }
}
