<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UsersModel
 * @package App\Models
 * @version August 12, 2025, 9:08 pm +08
 *
 * @property \App\Models\AimagCity $aimagCity
 * @property \App\Models\BagHoroo $bagHoroo
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \Illuminate\Database\Eloquent\Collection $notifications
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $registerHistory1s
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $register2s
 * @property \Illuminate\Database\Eloquent\Collection $register3s
 * @property string $name
 * @property string $username
 * @property string $password
 * @property integer $aimag_city_id
 * @property integer $soum_district_id
 * @property integer $bag_horoo_id
 * @property string $phone
 * @property string $place_id
 * @property string $roles
 * @property string $remember_token
 * @property string $push_token
 */
class UsersModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    use HasFilter;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $hidden = [
        'password',
        'remember_token',
        'push_token',
    ];




    public $fillable = [
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

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'username' => 'string',
        'password' => 'string',
        'aimag_city_id' => 'integer',
        'soum_district_id' => 'integer',
        'bag_horoo_id' => 'integer',
        'phone' => 'string',
        'place_id' => 'integer',
        'roles' => 'string',
        'remember_token' => 'string',
        'push_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'password' => 'required|string|max:255',
        'aimag_city_id' => 'required',
        'soum_district_id' => 'nullable',
        'bag_horoo_id' => 'nullable',
        'phone' => 'required|string|max:255',
        'place_id' => 'required',
        'roles' => 'required|string|max:255',
        'remember_token' => 'nullable|string|max:100',
        'push_token' => 'nullable|string|max:255',
        'created_at' => 'nullable|string',
        'updated_at' => 'nullable|string',
        'deleted_at' => 'nullable|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function aimag_city()
    {
        return $this->belongsTo(\App\Models\AimagCity::class, 'aimag_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function bag_horoo()
    {
        return $this->belongsTo(\App\Models\BagHoroo::class, 'bag_horoo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function soum_district()
    {
        return $this->belongsTo(\App\Models\SoumDistrict::class, 'soum_district_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function place()
    {
        return $this->belongsTo(\App\Models\Place::class, 'place_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function mynotifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'comf_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistory1s()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'reg_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registers()
    {
        return $this->hasMany(\App\Models\Register::class, 'allocate_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function register2s()
    {
        return $this->hasMany(\App\Models\Register::class, 'comf_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function register3s()
    {
        return $this->hasMany(\App\Models\Register::class, 'reg_user_id');
    }

    /**
     * @var array
     */
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

    /**
     * Filter Model
     *
     * @return array
     */
    public function getSearchIn()
    {
        return UsersModel::$searchIn;
    }
}
