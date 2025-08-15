<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{

    use HasFactory, Notifiable;
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
}
