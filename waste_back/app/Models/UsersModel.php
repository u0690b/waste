<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UsersModel
 *
 * @package App\Models
 * @version November 25, 2022, 1:42 pm UTC
 * @property \App\Models\AimagCity $aimagCity
 * @property \App\Models\BagHoroo $bagHoroo
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property string $name
 * @property string $username
 * @property string $password
 * @property integer $aimag_city_id
 * @property integer $soum_district_id
 * @property integer $bag_horoo_id
 * @property string $roles
 * @property string $remember_token
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AimagCity $aimag_city
 * @property-read \App\Models\BagHoroo $bag_horoo
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @property-read \App\Models\SoumDistrict $soum_district
 * @method static \Database\Factories\UsersModelFactory factory(...$parameters)
 * @method static Builder|UsersModel filter(array $filters)
 * @method static Builder|UsersModel newModelQuery()
 * @method static Builder|UsersModel newQuery()
 * @method static Builder|UsersModel query()
 * @method static Builder|UsersModel whereAimagCityId($value)
 * @method static Builder|UsersModel whereBagHorooId($value)
 * @method static Builder|UsersModel whereCreatedAt($value)
 * @method static Builder|UsersModel whereId($value)
 * @method static Builder|UsersModel whereName($value)
 * @method static Builder|UsersModel wherePassword($value)
 * @method static Builder|UsersModel whereRememberToken($value)
 * @method static Builder|UsersModel whereRoles($value)
 * @method static Builder|UsersModel whereSoumDistrictId($value)
 * @method static Builder|UsersModel whereUpdatedAt($value)
 * @method static Builder|UsersModel whereUsername($value)
 * @mixin \Eloquent
 */
class UsersModel extends Model
{

    use HasFactory;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        'username',
        'password',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'roles',
        'remember_token'
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
        'roles' => 'string',
        'remember_token' => 'string'
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
        'soum_district_id' => 'required',
        'bag_horoo_id' => 'required',
        'roles' => 'required|string',
        'remember_token' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registers()
    {
        return $this->hasMany(\App\Models\Register::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'user_id');
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
        'roles',
        'remember_token'
    ];

    /**
     * Filter Model
     * @param Array $filters
     * @return App\Models\UsersModel
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, UsersModel::$searchIn);
        }
        return $query;
    }
}
