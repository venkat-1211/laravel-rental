<?php

namespace Modules\Shared\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shared\Http\Requests\BaseFormRequest;
use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;

class FaqToggleRequest extends BaseFormRequest
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
            'id' => 'required|exists:f_a_q_s,id',
            'is_active' => 'required',
        ];
    }
}
