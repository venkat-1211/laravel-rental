<?php

namespace Modules\Shared\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CommonBuilder extends Builder
{
    public function id($id)
    {
        return $this->where('id', $id);
    }
}
