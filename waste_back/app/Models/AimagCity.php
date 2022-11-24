<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AimagCity
 * @package App\Models
 * @version November 24, 2022, 6:30 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Illuminate\Database\Eloquent\Collection $soumDistricts
 * @property string $code
 * @property string $name
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
