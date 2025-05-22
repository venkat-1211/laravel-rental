<?php

namespace Modules\Property\Http\Requests;

use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Property\Rules\LocationStartDateBeforeDeactivation;
use Modules\Shared\Http\Requests\BaseFormRequest;

class EditPropertyRequest extends BaseFormRequest
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->userRepository->superAdminAndAdminAccess();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Property details
            'property_type' => 'required|integer',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'location_gps' => 'required|string',
            'phone' => 'required|string',
            'description' => 'required|string',
            'total_rooms' => 'required|integer',
            'total_capacity' => 'required|integer',
            'franchise_chain_name' => 'nullable|string|max:255',
            'billing_method' => 'required|string|in:Card-(Visa/Master),Cash,UPI',
            'is_owned' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_franchise' => 'nullable|boolean',
            'from_deactivation_date' => 'nullable|date',
            'to_deactivation_date' => 'nullable|date|after_or_equal:from_deactivation_date',
            'location_start_date' => [
                'required',
                'date',
                new LocationStartDateBeforeDeactivation(
                    $this->input('from_deactivation_date'),
                    $this->input('to_deactivation_date')
                ),
            ],

            // Amenities
            'amenities' => 'required|array',
            'amenities.*' => 'integer|exists:amenities,id',

            // Property Images
            'images' => 'array',
            'images.*' => 'mimes:png,jpg|max:2048',

            'unit_capacity' => 'required|integer',

            // Pricing
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'slab' => 'required|string',
            'pricing' => 'required|numeric',
            'pricing_type' => 'required|string',
            'capacity' => 'required|integer',
            'max_capacity' => 'required|integer|gt:capacity',

            // Nearby
            'nearby_item' => 'required|string|in:Mahal,Hospital,University,Tech Park,Bus Stand,Railway Station',
            'nearby_distance' => 'required|numeric',
            'nearby_image' => 'mimes:png,jpg|max:2048',
        ];
    }
}
