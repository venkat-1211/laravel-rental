<?php

namespace Modules\Property\Rules;

use Illuminate\Contracts\Validation\Rule;

class LocationStartDateBeforeDeactivation implements Rule
{
    protected $from;

    protected $to;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function passes($attribute, $value)
    {
        $startDate = strtotime($value);

        if ($this->from && strtotime($this->from) <= $startDate) {
            return false;
        }

        if ($this->to && strtotime($this->to) <= $startDate) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Location Start Date must be before From/To Deactivation Date if those are provided.';
    }
}
