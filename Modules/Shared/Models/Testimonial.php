<?php

namespace Modules\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
       'property_id',
       'user_id',
       'ratings',
       'description',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
        
    // Global Scope
    protected static function booted() {
        static::addGlobalScope('activeTestimonials', function ($builder) {
            $builder->where('is_active', 1);
        });
    }
}
