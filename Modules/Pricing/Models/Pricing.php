<?php

namespace Modules\Pricing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Property\Models\Property;
use Modules\Shared\Models\Setting;

class Pricing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'unit',
        'slab',
        'pricing',
        'pricing_type',
        'capacity',
        'max_capacity',
        'deleted_at',
    ];

    protected $casts = [
        'unit' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function getUnitFinalAttribute()
    {
        $unit_final = $this->unit['bedrooms'].' Bed Rooms / '.$this->unit['bathrooms'].' Bathrooms';

        return $unit_final;
    }

    public function getTaxAttribute()
    {
        $taxRate = Setting::where('key', 'tax')->value('value') ?? 0;
        $tax = ($this->pricing * $taxRate) / 100;

        return $tax;
    }

    public function getTotalAttribute()
    {
        $total = $this->pricing + $this->tax;

        return $total;
    }
}
