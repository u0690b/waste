<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SoumDistrict
 * @package App\Models
 * @version November 24, 2022, 6:33 pm UTC
 *
 * @property \App\Models\AimagCity $aimagCity
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $bagHoroos
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property string $code
 * @property string $name
 * @property integer $aimag_city_id
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
        return $this;
    }
}
