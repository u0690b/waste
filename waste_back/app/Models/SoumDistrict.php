<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SoumDistrict
 *
 * @package App\Models
 * @version November 24, 2022, 7:40 pm UTC
 * @property \App\Models\AimagCity $aimagCity
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $bagHoroos
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property string $code
 * @property string $name
 * @property integer $aimag_city_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AimagCity $aimag_city
 * @property-read int|null $bag_horoos_count
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @property-read int|null $users_count
 * @method static \Database\Factories\SoumDistrictFactory factory(...$parameters)
 * @method static Builder|SoumDistrict filter(array $filters)
 * @method static Builder|SoumDistrict newModelQuery()
 * @method static Builder|SoumDistrict newQuery()
 * @method static Builder|SoumDistrict query()
 * @method static Builder|SoumDistrict whereAimagCityId($value)
 * @method static Builder|SoumDistrict whereCode($value)
 * @method static Builder|SoumDistrict whereCreatedAt($value)
 * @method static Builder|SoumDistrict whereId($value)
 * @method static Builder|SoumDistrict whereName($value)
 * @method static Builder|SoumDistrict whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SoumDistrict extends Model
{

    use HasFactory;

    public $table = 'soum_districts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'code',
        'name',
        'aimag_city_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'aimag_city_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'aimag_city_id' => 'required',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registers()
    {
        return $this->hasMany(\App\Models\Register::class, 'soum_district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'soum_district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function bagHoroos()
    {
        return $this->hasMany(\App\Models\BagHoroo::class, 'soum_district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'soum_district_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'code',
        'name',
        'aimag_city_id'
    ];

    /**
     * Filter Model
     * @param Array $filters
     * @return App\Models\SoumDistrict
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, SoumDistrict::$searchIn);
        }

    }
}
