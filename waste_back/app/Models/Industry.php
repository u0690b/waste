<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Industry
 * @package App\Models
 * @version January 18, 2023, 2:50 am +08
 *
 * @property \Illuminate\Database\Eloquent\Collection $legalEntities
 * @property string $name
 */
class Industry extends Model
{

    use HasFactory;

    public $table = 'industries';
    public $timestamps = false;
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
        'name' => 'required|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function legalEntities()
    {
        return $this->hasMany(\App\Models\LegalEntity::class, 'industry_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name'
    ];

    /**
     * Filter Model
     * @param array $filters
     * @return App\Models\Industry
     */
    #[Scope]
    public function Filter(Builder $query, array $filters): void
    {
        if (count($filters)) {
            $query =  $this->buildFilter($query, $filters, Industry::$searchIn);
        }

    }
}
