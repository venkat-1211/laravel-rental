<?php

namespace Modules\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;

class FAQ extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'question', 'answer', 'is_active'];


    public function user()
    {
        return $this->belongsTo(User::class);
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
}
