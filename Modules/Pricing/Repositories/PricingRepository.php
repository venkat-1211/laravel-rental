<?php

namespace Modules\Pricing\Repositories;

use Modules\Pricing\Models\Pricing;
use Modules\Pricing\Repositories\Interfaces\PricingRepositoryInterface;
use Modules\Shared\Data\GenericFormData;
use Yajra\DataTables\Facades\DataTables;

class PricingRepository implements PricingRepositoryInterface
{
    public function propertyPricings($request, $propertyId)
    {
        $data = $this->fetchPropertyWithTrashedPricings($propertyId);

        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('unit', function ($row) {
                return '
                    <div class="p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <p class="mb-0">'.$row['unit_final'].'</p>
                            </div>
                        </div>
                    </div>';
            })

            ->addColumn('slab', function ($row) {
                return '
                    <div class="p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <p class="mb-0">'.$row['slab'].'</p>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn('pricing', function ($row) {
                return '
                    <div class="p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <p class="mb-0">'.$row['pricing'].'</p>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn('pricing_type', function ($row) {
                return '
                    <div class="p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <p class="mb-0">'.$row['pricing_type'].'</p>
                            </div>
                        </div>
                    </div>';
            })

            ->addColumn('capacity', function ($row) {
                return '
                    <div class="p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <p class="mb-0">'.$row['capacity'].'</p>
                            </div>
                        </div>
                    </div>';
            })
            ->addColumn('max_capacity', function ($row) {
                return '
                    <div class="p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <p class="mb-0">'.$row['max_capacity'].'</p>
                            </div>
                        </div>
                    </div>';
            })

            // Status Action Button
            ->addColumn('status_action', function ($row) {
                $checked = ! $row['deleted_at'] ? 'checked' : '';

                return '
                <div class="d-flex justify-content-center p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                    <label class="form-switch">
                        <input type="checkbox" class="form-check-input pricing-toggle visually-hidden"
                                data-id="'.$row['id'].'" '.$checked.'>
                        <span class="slider"></span>
                    </label>
                </div>';
            })

             // Status Action Button
            ->addColumn('action', function ($row) {

                return '
                    <div class="p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                        <a href="#"
                           class="btn btn-sm btn-gradient-primary text-white d-flex align-items-center gap-2 shadow rounded-pill px-3 py-2 edit-pricing"
                           data-bs-toggle="modal"
                           data-bs-target="#editPricingModal"
                           title="Edit Pricing"
                           data-id="'.$row['id'].'"
                           data-bedrooms="'.$row['bedrooms'].'"
                           data-bathrooms="'.$row['bathrooms'].'"
                           data-slab="'.$row['slab'].'"
                           data-pricing="'.$row['pricing'].'"
                           data-pricing_type="'.$row['pricing_type'].'"
                           data-capacity="'.$row['capacity'].'"
                           data-max_capacity="'.$row['max_capacity'].'">
                            <i class="bi bi-pencil-fill fs-6"></i> <strong>Edit</strong>
                        </a>

                        <form action="'.route('property.pricings.delete', [$row['property_slug'], $row['id']]).'" method="POST" class="d-inline-block">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit"
                                    class="btn btn-sm btn-gradient-danger text-white d-flex align-items-center gap-2 shadow rounded-pill px-3 py-2"
                                    title="Delete Admin">
                                <i class="bi bi-trash3-fill fs-6"></i> <strong>Remove</strong>
                            </button>
                        </form>

                    </div>';
            })
            //

            ->rawColumns(['unit', 'slab', 'pricing', 'pricing_type', 'capacity', 'max_capacity', 'status_action', 'action'])
            ->make(true);
    }

    public function fetchPropertyWithTrashedPricings($propertyId)
    {
        // Fetch all pricings for the property with soft-deleted included
        $pricings = Pricing::withTrashed()
            ->where('property_id', $propertyId)
            ->with('property') // Include the property relation
            ->get();

        // Map each pricing to the desired output format
        return $pricings->map(function ($pricing) {
            return [
                'property_slug' => $pricing->property->slug ?? null,
                'id' => $pricing->id,
                'bedrooms' => $pricing->unit['bedrooms'],
                'bathrooms' => $pricing->unit['bathrooms'],
                'unit_final' => $pricing->unit_final,
                'slab' => $pricing->slab,
                'pricing' => $pricing->pricing,
                'pricing_type' => $pricing->pricing_type,
                'capacity' => $pricing->capacity,
                'max_capacity' => $pricing->max_capacity,
                'deleted_at' => $pricing->deleted_at,
            ];
        });
    }

    public function addPropertyPricing($request, $property, $handler)
    {
        $property_pricng_data = GenericFormData::fromRequest($request, ['bedrooms', 'bathrooms', 'slab', 'pricing', 'pricing_type', 'capacity', 'max_capacity'], ['deleted_at' => NOW()]);

        $pricing_customize_data[] = [
            'property_id' => $property->id,
            'unit' => [
                'bedrooms' => $property_pricng_data->get('bedrooms'),
                'bathrooms' => $property_pricng_data->get('bathrooms'),
            ],
            'slab' => $property_pricng_data->get('slab'),
            'pricing' => $property_pricng_data->get('pricing'),
            'pricing_type' => $property_pricng_data->get('pricing_type'),
            'capacity' => $property_pricng_data->get('capacity'),
            'max_capacity' => $property_pricng_data->get('max_capacity'),
            'deleted_at' => $property_pricng_data->get('deleted_at'),
        ];

        $handler->createChildren($property, 'pricings', $pricing_customize_data);

        return redirect()->route('property.pricings', [$property->slug])->with('success', 'Pricing added successfully.');
    }

    public function editPropertyPricing($request, $handler, $pricing)
    {
        $property_pricng_data = GenericFormData::fromRequest($request, ['bedrooms', 'bathrooms', 'slab', 'pricing', 'pricing_type', 'capacity', 'max_capacity']);

        $pricing_customize_data = [
            'unit' => [
                'bedrooms' => $property_pricng_data->get('bedrooms'),
                'bathrooms' => $property_pricng_data->get('bathrooms'),
            ],
            'slab' => $property_pricng_data->get('slab'),
            'pricing' => $property_pricng_data->get('pricing'),
            'pricing_type' => $property_pricng_data->get('pricing_type'),
            'capacity' => $property_pricng_data->get('capacity'),
            'max_capacity' => $property_pricng_data->get('max_capacity'),
        ];

        $final_data = GenericFormData::fromArray($pricing_customize_data);

        $handler->update($final_data, $pricing);

        // return redirect()->route('property.pricings', [$property->slug])->with('success', 'Pricing updated successfully.');
        return redirect()->back()->with('success', 'Pricing updated successfully.');
    }

    public function togglePricing($request, $handler)
    {
        $pricing_data = GenericFormData::fromRequest($request, ['id', 'is_active']);
        $deleted_at = $pricing_data->get('is_active') == 1 ? null : now();
        $pricing_customize_data = [
            'deleted_at' => $deleted_at,
        ];
        $pricing_customize_data_final = GenericFormData::fromArray($pricing_customize_data);
        $pricing = $this->pricingSole($pricing_data->get('id'));

        $handler->update($pricing_customize_data_final, $pricing);

        return response()->json(['message' => 'Pricing status updated successfully.']);
    }

    public function pricingSole($id)
    {
        return Pricing::withTrashed()->where('id', $id)->sole();
    }

    public function deletePropertyPricing($property, $id, $handler)
    {
        $pricing = $this->pricingSole($id);
        $handler->forceDelete($pricing);

        return redirect()->route('property.pricings', [$property->slug])->with('success', 'Pricing deleted successfully.');
    }
}
