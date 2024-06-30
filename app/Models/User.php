<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Support\Facades\Hash;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->user_type === 3 || $this->user_type === 2;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type',
        'subscription_id',
        'avatar_path',
        'name',
        'email',
        'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setAvatarPathAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['avatar_path'] = 'avatars/default.png';
        } else {
            $this->attributes['avatar_path'] = $value;
        }
    }

    public function getUserType()
    {
        return $this->belongsTo(UserType::class, 'user_type');
    }

    public function getSubscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }
}
