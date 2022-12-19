<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Register
 * @package App\Models
 * @version December 13, 2022, 5:49 am UTC
 *
 * @property \App\Models\AimagCity $aimagCity
 * @property \App\Models\BagHoroo $bagHoroo
 * @property \App\Models\User $comfUser
 * @property \App\Models\Reason $reason
 * @property \App\Models\User $regUser
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \App\Models\Status $status
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property string $name
 * @property string $register
 * @property string $chiglel
 * @property integer $aimag_city_id
 * @property integer $soum_district_id
 * @property integer $bag_horoo_id
 * @property string $address
 * @property string $description
 * @property integer $reason_id
 * @property string $zuil_zaalt
 * @property string $resolve_desc
 * @property number $long
 * @property number $lat
 * @property integer $reg_user_id
 * @property integer $comf_user_id
 * @property integer $status_id
 */
class Register extends Model
{

    use HasFactory;

    public $table = 'registers';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        'register',
        'chiglel',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'address',
        'description',
        'reason_id',
        'zuil_zaalt',
        'resolve_desc',
        'long',
        'lat',
        'reg_user_id',
        'comf_user_id',
        'status_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'register' => 'string',
        'chiglel' => 'string',
        'aimag_city_id' => 'integer',
        'soum_district_id' => 'integer',
        'bag_horoo_id' => 'integer',
        'address' => 'string',
        'description' => 'string',
        'reason_id' => 'integer',
        'zuil_zaalt' => 'string',
        'resolve_desc' => 'string',
        'long' => 'float',
        'lat' => 'float',
        'reg_user_id' => 'integer',
        'comf_user_id' => 'integer',
        'status_id' => 'integer',
        'created_at' =>'date:Y-m-d H:i:s'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'register' => 'nullable|string|max:255',
        'chiglel' => 'nullable|string|max:255',
        'aimag_city_id' => 'required',
        'soum_district_id' => 'required',
        'bag_horoo_id' => 'required',
        'address' => 'nullable|string|max:500',
        'description' => 'required|string|max:2000',
        'reason_id' => 'required',
        'zuil_zaalt' => 'nullable|string|max:1000',
        'resolve_desc' => 'nullable|string|max:2000',
        'long' => 'required|numeric',
        'lat' => 'required|numeric',
        'comf_user_id' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'images' => 'sometimes|array',
        'images.*' => 'sometimes|file',
        'video' => 'sometimes|file',
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
    public function comf_user()
    {
        return $this->belongsTo(\App\Models\User::class, 'comf_user_id');
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
    public function reg_user()
    {
        return $this->belongsTo(\App\Models\User::class, 'reg_user_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'register_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attached_images()
    {
        return $this->hasMany(\App\Models\AttachedFile::class, 'register_id')->where('type', 'img');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function attached_video()
    {
        return $this->HasOne(\App\Models\AttachedFile::class, 'register_id')->where('type', 'video');
    }
    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'register',
        'chiglel',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'address',
        'description',
        'reason_id',
        'zuil_zaalt',
        'resolve_desc',
        'long',
        'lat',
        'reg_user_id',
        'comf_user_id',
        'status_id'
    ];

    /**
     * Filter Model
     * @param Array $filters
     * @return App\Models\Register
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $query = $this->buildFilter($query, $filters, Register::$searchIn);
        }
        return $query;
    }
}