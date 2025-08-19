<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends UsersModel
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static $searchIn = [
        'name',
        'username',
        'password',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'phone',
        'place_id',
        'roles',
        'remember_token',
        'push_token'
    ];

    public static $rolesModel = [
        "admin" => "Админ",
        "zaa" => "Захирагчийн ажлын алба",
        "mha" => "МХ байцаагч",
        "da" => "Дүүргийн ЗДТГ",
        "hd" => "Хорооны засаг дарга",
        "onb" => "Олон нийтийн байцаагч",
        "boajy" => "Байгаль орчин, аялал жуулчлалын яам",
        "bhby" => "Барилга, хот байгуулалтын яам",
        "emy" => "Эрүүл мэндийн яам",
        "none" => "Идэвхигүй",
    ];
}
