<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;

class SpecialDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'property_id', 'date', 'description', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function scopeVisibleTo($query, $user)
    {
        if ($user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }
    }

    public function getDateAttribute($value)
    {
        return date('d M Y', strtotime($value));
    }
}
