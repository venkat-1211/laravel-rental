<?php

namespace Modules\Nearby\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Property\Models\Property;

class Nearby extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['property_id', 'item', 'image_kms', 'deleted_at'];

    protected $casts = [
        'image_kms' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function getDistanceKmsAttribute()
    {
        return $this->image_kms['distance'].' kms';
    }
}
