<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AimagCity
 *
 * @package App\Models
 * @version November 24, 2022, 7:40 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Illuminate\Database\Eloquent\Collection $soumDistricts
 * @property string $code
 * @property string $name
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @property-read int|null $soum_districts_count
 * @property-read int|null $users_count
 * @method static \Database\Factories\AimagCityFactory factory(...$parameters)
 * @method static Builder|AimagCity filter(array $filters)
 * @method static Builder|AimagCity newModelQuery()
 * @method static Builder|AimagCity newQuery()
 * @method static Builder|AimagCity query()
 * @method static Builder|AimagCity whereCode($value)
 * @method static Builder|AimagCity whereCreatedAt($value)
 * @method static Builder|AimagCity whereId($value)
 * @method static Builder|AimagCity whereName($value)
 * @method static Builder|AimagCity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AimagCity extends Model
{

    use HasFactory;

    public $table = 'aimag_cities';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'code',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registers()
    {
        return $this->hasMany(\App\Models\Register::class, 'aimag_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'aimag_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'aimag_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function soumDistricts()
    {
        return $this->hasMany(\App\Models\SoumDistrict::class, 'aimag_city_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'code',
        'name'
    ];

    /**
    * Filter Model
    * @param Array $filters
    * @return App\Models\AimagCity
    */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, AimagCity::$searchIn);
        }
        return $this;
    }
}
