<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LegalEntity
 * @package App\Models
 * @version January 18, 2023, 5:16 am +08
 *
 * @property string $register
 * @property string $name
 * @property string $industry
 */
class LegalEntity extends Model
{

    use HasFactory;
    public $timestamps = false;
    public $table = 'legal_entity';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'register',
        'name',
        'industry'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'register' => 'string',
        'name' => 'string',
        'industry' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'register' => 'required|string|max:255',
        'name' => 'required|string|max:2000',
        'industry' => 'required|string|max:200'
    ];

    

    /**
     * @var array
     */
    public static $searchIn = [
        'name',
    ];

    /**
    * Filter Model
    * @param Array $filters
    * @return App\Models\LegalEntity
    */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $query =  $this->buildFilter($query, $filters, LegalEntity::$searchIn);
        }
        return $query;
    }
}
