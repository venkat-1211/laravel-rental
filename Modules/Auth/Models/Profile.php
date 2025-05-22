<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $casts = [
        'address' => 'array',
        'aadhaar' => 'array',
        'pan' => 'array',
        'bank' => 'array',
        'upi' => 'array',
    ];

    protected $fillable = ['user_id', 'phone', 'profile_image', 'address', 'reward_points', 'aadhaar', 'pan', 'gst_number', 'bank', 'upi'];

    public function getProfileImageAttribute($image) {
        if (empty($image)) {
            return asset('assets/images/user/user-3296.png');
        }
        return asset('assets/images/user/'.$image);
    }
}
