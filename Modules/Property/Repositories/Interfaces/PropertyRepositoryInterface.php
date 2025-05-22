<?php

namespace Modules\Property\Repositories\Interfaces;

interface PropertyRepositoryInterface
{
    public function allPropertyTypes();

    public function addProperty($request, $handler);
}
