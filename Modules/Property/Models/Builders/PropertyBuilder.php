<?php

namespace Modules\Property\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PropertyBuilder extends Builder
{
    public function like($column, $value)
    {
        return $this->where($column, 'like', '%'.$value.'%');
    }

    public function orLike($column, $value)
    {
        return $this->orWhere($column, 'like', '%'.$value.'%');
    }

    public function notLike($column, $value)
    {
        return $this->where($column, 'not like', '%'.$value.'%');
    }
}
