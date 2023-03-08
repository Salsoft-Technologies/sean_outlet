<?php

namespace App\Models;

use App\Models\Image;
use App\Models\TimeSlot;
use App\Models\BankDetail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";
    protected $primaryKey = "id";

    public const MALE = '1';
    public const FEMALE = '0';

    protected $fillable = [
        'full_name',
        'user_name',
        'gender',
        'phone_number',
        'email',
        'age',
        'location',
        'password',
        'about',
        'hobbies',
        'role_id',
        'avatar',
        'status',
        'price',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        // 'avatar' => 'storage/default.png',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'hobbies' => 'array',
    ];

    public function time_slot(){
        return $this->hasMany(TimeSlot::class);
    }

    public function bank_detail(){
        return $this->hasOne(BankDetail::class);
    }

    public function my_images(){
        return $this->hasMany(Image::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}