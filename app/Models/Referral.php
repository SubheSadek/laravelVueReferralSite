<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'referred_by',
        'code',
        'is_registered',
    ];

    public function scopeFilter($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('email', 'like', '%'.$search.'%');
                $query->whereHas('referredBy', function (Builder $query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
            });
        });
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id')->select('id', 'name', 'email', 'user_type');
    }
}
