<?php

namespace Modules\Pricing\Http\Requests;

use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Shared\Http\Requests\BaseFormRequest;

class EditPropertyPricingRequest extends BaseFormRequest
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
            'id' => 'exists:pricings,id',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'slab' => 'required|string',
            'pricing' => 'required|numeric',
            'pricing_type' => 'required|string',
            'capacity' => 'required|integer',
            'max_capacity' => 'required|integer|gt:capacity',
        ];
    }
}
