<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Status
 * @package App\Models
 * @version November 24, 2022, 2:55 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property string $name
 */
class Status extends Model
{

    use HasFactory;

    public $table = 'statuses';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registers()
    {
        return $this->hasMany(\App\Models\Register::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'status_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name'
    ];

    /**
    * Filter Model
    * param Array $filters
    * return Status
    */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            foreach ($filters as $key => $value) {
                if (! $value) {
                    continue;
                }
                if ($key === 'search') {
                    $this->buildSearch($query, $filters['search'] ?? '', Status::$searchIn);
                } elseif (is_array($value)) {
                    $query = $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }
    }
}
