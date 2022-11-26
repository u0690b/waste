<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Reason
 *
 * @package App\Models
 * @version November 24, 2022, 7:41 pm UTC
 * @property \App\Models\Place $place
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property string $name
 * @property integer $place_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @method static \Database\Factories\ReasonFactory factory(...$parameters)
 * @method static Builder|Reason filter(array $filters)
 * @method static Builder|Reason newModelQuery()
 * @method static Builder|Reason newQuery()
 * @method static Builder|Reason query()
 * @method static Builder|Reason whereCreatedAt($value)
 * @method static Builder|Reason whereId($value)
 * @method static Builder|Reason whereName($value)
 * @method static Builder|Reason wherePlaceId($value)
 * @method static Builder|Reason whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reason extends Model
{

    use HasFactory;

    public $table = 'reasons';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name',
        'place_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'place_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'place_id' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
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
    public function registers()
    {
        return $this->hasMany(\App\Models\Register::class, 'reason_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'reason_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'place_id'
    ];

    /**
    * Filter Model
    * @param Array $filters
    * @return App\Models\Reason
    */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, Reason::$searchIn);
        }
        return $this;
    }
}
