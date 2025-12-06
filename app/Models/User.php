<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_code',
        'promo_code',
        'ref_user_id',
        'first_name',
        'last_name',
        'user_name',
        'mobile',
        'email',
        'google_id',
        'password',
        'image',
        'state',
        'city',
        'date_of_birth',
        'gender',
        'latitude',
        'longitude',
        'fcm_token',
        'last_login_token',
        'notification_setting',
        'wallet_balance',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey(); // Returns user ID
    }

    public function getJWTCustomClaims()
    {
        return []; // No additional claims
    }

  

    protected $appends = ['image_url'];


    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return '';
        }
         return asset('uploads/user/' . $this->image);
    }



    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    
}