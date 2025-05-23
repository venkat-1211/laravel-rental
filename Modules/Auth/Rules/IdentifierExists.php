<?php

namespace Modules\Auth\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Auth\Models\User;

class IdentifierExists implements ValidationRule
{
    protected string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Only apply this rule when type is 'register'
        if ($this->type === 'register') {
            $exists = User::where('email', $value)
                ->orWhereHas('profile', function ($query) use ($value) {
                    $query->where('phone', $value);
                })
                ->exists();

            if ($exists) {
                $fail('The provided email or phone number is already registered.');
            }
        } elseif ($this->type === "forgot") {
            $exists = User::where('email', $value)
                ->orWhereHas('profile', function ($query) use ($value) {
                    $query->where('phone', $value);
                })
                ->exists();

            if (! $exists) {
                $fail('The provided email or phone number is not registered.');
            }
        }
        
    }
}
