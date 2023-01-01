<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Resolve
 * @package App\Models
 * @version January 1, 2023, 3:15 pm +08
 *
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property string $name
 */
class Resolve extends Model
{

    use HasFactory;

    public $table = 'resolves';
    
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
        return $this->hasMany(\App\Models\Register::class, 'resolve_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name'
    ];

    /**
    * Filter Model
    * @param Array $filters
    * @return App\Models\Resolve
    */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $query =  $this->buildFilter($query, $filters, Resolve::$searchIn);
        }
        return $query;
    }
}
