<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Amenity\Models\Amenity;
use Modules\Auth\Models\User;
use Modules\Nearby\Models\Nearby;
use Modules\Pricing\Models\Pricing;
use Modules\Shared\Models\Testimonial;
use Modules\Property\Models\Builders\PropertyBuilder;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'property_type_id',
        'location_gps',
        'address',
        'phone',
        'description',
        'total_rooms',
        'total_capacity',
        'is_owned',
        'is_active',
        'is_franchise',
        'deactivated_date',
        'location_start_date',
        'billing_method',
        'franchise_chain_name',
    ];

    protected $casts = [
        'deactivated_date' => 'array',
        'location_gps' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenity')->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function pricings()
    {
        return $this->hasMany(Pricing::class)->withTrashed();
    }

    public function nearbies()
    {
        return $this->hasMany(Nearby::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_property')->where('end_date', '>=', date('Y-m-d'))->where('is_active', 1);
    }

    public function scopeVisibleTo($query, $user)
    {
        if ($user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }
    }

    public function newEloquentBuilder($query)
    {
        return new PropertyBuilder($query);
    }
}
