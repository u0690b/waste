<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Reason
 * @package App\Models
 * @version August 12, 2025, 8:00 pm +08
 *
 * @property \App\Models\Place $place
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property string $code Шалтгаан код
 * @property string $name Шалтгаан
 * @property string $sub_group Хог хаягдлын дэд бүлэг
 * @property string $stype Төрөл
 * @property integer $place_id Хог хаягдлын бүлэг
 */
class Reason extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'reasons';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'code',
        'name',
        'sub_group',
        'stype',
        'place_id'
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
        'sub_group' => 'string',
        'stype' => 'string',
        'place_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required|string|max:255',
        'name' => 'required|string|max:1000',
        'sub_group' => 'required|string|max:1000',
        'stype' => 'required|string|max:255',
        'place_id' => 'required',
        'created_at' => 'nullable|string',
        'updated_at' => 'nullable|string'
    ];

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
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'reason_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registers()
    {
        return $this->hasMany(\App\Models\Register::class, 'reason_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'code',
        'name',
        'sub_group',
        'stype',
        'place_id'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return Reason::$searchIn;
    }
}
