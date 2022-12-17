<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BagHoroo
 *
 * @package App\Models
 * @version November 24, 2022, 7:40 pm UTC
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property string $code
 * @property string $name
 * @property integer $soum_district_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @property-read \App\Models\SoumDistrict $soum_district
 * @property-read int|null $users_count
 * @method static \Database\Factories\BagHorooFactory factory(...$parameters)
 * @method static Builder|BagHoroo filter(array $filters)
 * @method static Builder|BagHoroo newModelQuery()
 * @method static Builder|BagHoroo newQuery()
 * @method static Builder|BagHoroo query()
 * @method static Builder|BagHoroo whereCode($value)
 * @method static Builder|BagHoroo whereCreatedAt($value)
 * @method static Builder|BagHoroo whereId($value)
 * @method static Builder|BagHoroo whereName($value)
 * @method static Builder|BagHoroo whereSoumDistrictId($value)
 * @method static Builder|BagHoroo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BagHoroo extends Model
{

    use HasFactory;

    public $table = 'bag_horoos';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'code',
        'name',
        'soum_district_id'
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
        'soum_district_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'soum_district_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

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
        return $this->hasMany(\App\Models\Register::class, 'bag_horoo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'bag_horoo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'bag_horoo_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'code',
        'name',
        'soum_district_id'
    ];

    /**
     * Filter Model
     * @param Array $filters
     * @return App\Models\BagHoroo
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, BagHoroo::$searchIn);
        }
        return $query;
    }
}
