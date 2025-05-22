<?php

namespace Modules\Property\Http\Requests;

use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Property\Rules\AdminRequired;
use Modules\Shared\Http\Requests\BaseFormRequest;

class AddCouponRequest extends BaseFormRequest
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
            'code' => 'required|unique:coupons,code',
            'value' => 'required',
            'description' => 'required|string',
            'type' => 'required|string|in:percentage,amount',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'property_ids' => ['nullable', 'array', new AdminRequired],
            'property_ids.*' => ['exists:properties,id'],
        ];
    }
}
