<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BagHoroo
 * @package App\Models
 * @version August 12, 2025, 7:26 pm +08
 *
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property string $code Код
 * @property string $name Баг,Хороо
 * @property integer $soum_district_id Сум,Дүүрэг
 */
class BagHoroo extends Model
{

    use HasFactory;

    use HasFilter;

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
        'created_at' => 'nullable|string',
        'updated_at' => 'nullable|string'
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
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'bag_horoo_id');
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
        'soum_district_id',
        'soum_districts:id:soum_district_id:name',
    ];

    /**
     * Filter Model
     *
     * @return array
     */
    public function getSearchIn()
    {
        return BagHoroo::$searchIn;
    }
}
