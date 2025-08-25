<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Customer
 * @package App\Models
 * @version August 18, 2025, 1:50 am +08
 *
 * @property string $regnum
 * @property string $firstname
 * @property string $gender
 * @property string $image
 * @property string $lastname
 * @property string $nationality
 * @property string $passportAddress
 * @property string $passportExpireDate
 * @property string $passportIssueDate
 * @property string $soumDistrictCode
 * @property string $soumDistrictName
 * @property string $surname
 * @property string $token
 * @property string $remember_token
 * @property string $push_token
 */
class Customer extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'customers';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $appends = array('name');

    public function getNameAttribute()
    {
        return "{$this->regnum} {$this->firstname} {$this->lastname}";
    }

    public $fillable = [
        'regnum',
        'firstname',
        'gender',
        'image',
        'lastname',
        'nationality',
        'passportAddress',
        'passportExpireDate',
        'passportIssueDate',
        'soumDistrictCode',
        'soumDistrictName',
        'surname',
        'token',
        'remember_token',
        'push_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
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
        'remember_token' => 'string',
        'push_token' => 'string'
    ];
    protected $hidden = [
        'token',
        'remember_token',
        'push_token'
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'regnum' => 'required|string|max:255',
        'firstname' => 'nullable|string|max:255',
        'gender' => 'nullable|string|max:255',
        'image' => 'nullable|string',
        'lastname' => 'nullable|string|max:255',
        'nationality' => 'nullable|string|max:255',
        'passportAddress' => 'nullable|string|max:255',
        'passportExpireDate' => 'nullable|string|max:255',
        'passportIssueDate' => 'nullable|string|max:255',
        'soumDistrictCode' => 'nullable|string|max:255',
        'soumDistrictName' => 'nullable|string|max:255',
        'surname' => 'nullable|string|max:255',
        'token' => 'nullable|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'push_token' => 'nullable|string|max:255',
        'created_at' => 'nullable|string',
        'updated_at' => 'nullable|string'
    ];



    /**
     * @var array
     */
    public static $searchIn = [
        'regnum',
        'firstname',
        'gender',
        'image',
        'lastname',
        'nationality',
        'passportAddress',
        'passportExpireDate',
        'passportIssueDate',
        'soumDistrictCode',
        'soumDistrictName',
        'surname',
        'token',
        'remember_token',
        'push_token'
    ];

    /**
     * Filter Model
     *
     * @return array
     */
    public function getSearchIn()
    {
        return Customer::$searchIn;
    }
}
