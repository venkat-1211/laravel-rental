<?php

namespace Modules\Nearby\Repositories;

use Modules\Nearby\Models\Nearby;
use Modules\Nearby\Repositories\Interfaces\NearbyRepositoryInterface;
use Modules\Shared\Data\GenericFormData;
use Modules\Shared\Services\FileUploadService;
use Yajra\DataTables\Facades\DataTables;

class NearbyRepository implements NearbyRepositoryInterface
{
    protected $uploadService;

    public function __construct(FileUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function propertyNearbies($request, $propertyId)
    {
        $data = $this->fetchPropertyWithTrashedNearbies($propertyId);

        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('nearby_info', function ($row) {
                $image = $row['image'] ? asset('assets/images/nearby_images/'.$row['image']) : asset('assets/images/default.png');

                return '
                    <div class="d-flex align-items-center gap-4 p-3 border rounded-3 shadow-sm bg-white" style="min-height: 100px;">
                        <img src="'.$image.'" alt="Nearby Image" class="shadow-sm" width="80" height="80" style="object-fit: cover; border-radius: 10px;">
                        <div class="d-flex flex-column justify-content-center">
                            <span class="fw-bold fs-5 text-dark">'.$row['item'].'</span>
                            <span class="text-secondary">Distance: '.$row['distance'].'</span>
                        </div>
                    </div>';
            })

            // Status Action Button
            ->addColumn('status_action', function ($row) {
                $checked = ! $row['deleted_at'] ? 'checked' : '';

                return '
                <div class="d-flex justify-content-center p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                    <label class="form-switch">
                        <input type="checkbox" class="form-check-input nearby-toggle visually-hidden"
                                data-id="'.$row['id'].'" '.$checked.'>
                        <span class="slider"></span>
                    </label>
                </div>';
            })

             // Status Action Button
            ->addColumn('action', function ($row) {

                return '
                    <div class="p-2 bg-light border rounded shadow-sm d-flex flex-wrap align-items-center gap-2">
                        <form action="'.route('property.nearbies.delete', [$row['property_slug'], $row['id']]).'" method="POST" class="d-inline-block">
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

            ->rawColumns(['nearby_info', 'status_action', 'action'])
            ->make(true);
    }

    public function fetchPropertyWithTrashedNearbies($propertyId)
    {
        // Fetch all pricings for the property with soft-deleted included
        $nearbies = Nearby::withTrashed()
            ->where('property_id', $propertyId)
            ->with('property') // Include the property relation
            ->get();

        // Map each pricing to the desired output format
        return $nearbies->map(function ($nearbies) {
            return [
                'property_slug' => $nearbies->property->slug ?? null,
                'id' => $nearbies->id,
                'item' => $nearbies->item,
                'image' => $nearbies->image_kms['image_path'] ?? null,
                'distance' => $nearbies->distance_kms ?? null,
                'deleted_at' => $nearbies->deleted_at,
            ];
        });
    }

    public function addPropertyNearby($request, $property, $handler)
    {
        // Property Nearby Table Add
        $nearby_data = GenericFormData::fromRequest($request, ['nearby_item', 'nearby_distance', 'nearby_image']);

        // File Upload
        if ($request->hasFile('nearby_image')) {
            $imagePath = $this->uploadService->uploadToPublic(
                $request->file('nearby_image'),
                'nearby_images'
            );
        }

        $nearby_customize_data = [
            'property_id' => $property->id,
            'item' => $nearby_data->get('nearby_item'),
            'image_kms' => [
                'image_path' => $imagePath ?? null,
                'distance' => $nearby_data->get('nearby_distance'),
            ],
            'deleted_at' => now(),
        ];

        $handler->createChildren($property, 'nearbies', [$nearby_customize_data]);

        return redirect()->route('property.nearbies', [$property->slug])->with('success', 'Nearby Added successfully!');
    }

    public function toggleNearby($request, $handler)
    {
        $nearby_data = GenericFormData::fromRequest($request, ['id', 'is_active']);
        $deleted_at = $nearby_data->get('is_active') == 1 ? null : now();
        $nearby_customize_data = [
            'deleted_at' => $deleted_at,
        ];
        $nearby_customize_data_final = GenericFormData::fromArray($nearby_customize_data);
        $nearby = $this->nearbySole($nearby_data->get('id'));

        $handler->update($nearby_customize_data_final, $nearby);

        return response()->json(['message' => 'Nearby status updated successfully.']);
    }

    public function nearbySole($id)
    {
        return Nearby::withTrashed()->where('id', $id)->sole();
    }

    public function deletePropertyNearby($property, $id, $handler)
    {
        $nearby = $this->nearbySole($id);
        $handler->forceDelete($nearby);

        return redirect()->route('property.nearbies', [$property->slug])->with('success', 'Nearby deleted successfully.');
    }
}
