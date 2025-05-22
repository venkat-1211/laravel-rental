<?php

namespace Modules\Nearby\Http\Requests;

use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Shared\Http\Requests\BaseFormRequest;

class AddPropertyNearbyRequest extends BaseFormRequest
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
            // Nearby
            'nearby_item' => 'required|string|in:Mahal,Hospital,University,Tech Park,Bus Stand,Railway Station',
            'nearby_distance' => 'required|numeric',
            'nearby_image' => 'required|mimes:png,jpg|max:2048',
        ];
    }
}
