<?php

namespace Modules\Auth\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Auth\Models\User;

class IdentifierExists implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = User::where('email', $value)
            ->orWhereHas('profile', function ($query) use ($value) {
                $query->where('phone', $value);
            })
            ->exists();

        if ($exists) {
            $fail('The provided email or phone number is already registered.');
        }
    }
}
