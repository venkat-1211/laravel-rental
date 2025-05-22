<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'value',
        'description',
        'type',
        'start_date',
        'end_date',
        'user_id',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'coupon_property');
    }

    public function scopeVisibleTo($query, $user)
    {
        if ($user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
