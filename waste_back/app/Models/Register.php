<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Register
 * @package App\Models
 * @version November 24, 2022, 6:57 pm UTC
 *
 * @property \App\Models\AimagCity $aimagCity
 * @property \App\Models\BagHoroo $bagHoroo
 * @property \App\Models\Reason $reason
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \App\Models\Status $status
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property number $long
 * @property number $lat
 * @property string $description
 * @property string $resolve_desc
 * @property integer $reason_id
 * @property integer $status_id
 * @property integer $aimag_city_id
 * @property integer $soum_district_id
 * @property integer $bag_horoo_id
 * @property string $address
 * @property integer $user_id
 */
class Register extends Model
{

    use HasFactory;

    public $table = 'registers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'long',
        'lat',
        'description',
        'resolve_desc',
        'reason_id',
        'status_id',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'address',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'long' => 'float',
        'lat' => 'float',
        'description' => 'string',
        'resolve_desc' => 'string',
        'reason_id' => 'integer',
        'status_id' => 'integer',
        'aimag_city_id' => 'integer',
        'soum_district_id' => 'integer',
        'bag_horoo_id' => 'integer',
        'address' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'long' => 'required|numeric',
        'lat' => 'required|numeric',
        'description' => 'required|string|max:255',
        'resolve_desc' => 'required|string|max:255',
        'reason_id' => 'required',
        'status_id' => 'required',
        'aimag_city_id' => 'required',
        'soum_district_id' => 'required',
        'bag_horoo_id' => 'required',
        'address' => 'nullable|string|max:255',
        'user_id' => 'required',
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
    public function reason()
    {
        return $this->belongsTo(\App\Models\Reason::class, 'reason_id');
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
    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'register_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'long',
        'lat',
        'description',
        'resolve_desc',
        'reason_id',
        'status_id',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'address',
        'user_id'
    ];

    /**
    * Filter Model
    * @param Array $filters
    * @return App\Models\Register
    */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, Register::$searchIn);
        }
        return $this;
    }
}
