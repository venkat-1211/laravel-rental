<?php

namespace Modules\Amenity\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Property\Models\Property;
use Modules\Shared\Models\Builders\CommonBuilder;

class Amenity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'slug', 'icon', 'is_active'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_amenity')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('Modules\Auth\Models\User');
    }

    public function scopeVisibleTo($query, $user)
    {
        if ($user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function newEloquentBuilder($query)
    {
        return new CommonBuilder($query);
    }
}
