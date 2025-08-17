<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens;
    protected $fillable = [
        'regnum',
        'firstname' ,
        'gender' ,
        'image' ,
        'lastname' ,
        'nationality' ,
        'passportAddress' ,
        'passportExpireDate' ,
        'passportIssueDate' ,
        'soumDistrictCode' ,
        'soumDistrictName' ,
        'surname' ,
        'token',
    ];

    protected $hidden = [
        'token',
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
            'regnum' => 'string',
            'firstname' => 'string',
            'gender' => 'string',
            'image' => 'string',
            'lastname' => 'string',
            'nationality' => 'string',
            'passportAddress' => 'string',
            'passportExpireDate' => 'string',
            'passportIssueDate' => 'string',
            'soumDistrictCode' => 'string',
            'soumDistrictName' => 'string',
            'surname' => 'string',
            'token' => 'string',
        ];
    }
}
