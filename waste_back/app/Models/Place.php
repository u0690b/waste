<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Place
 * @package App\Models
 * @version August 12, 2025, 7:56 pm +08
 *
 * @property \Illuminate\Database\Eloquent\Collection $reasons
 * @property string $name Газрын нэр
 */
class Place extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'places';
    
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
        'created_at' => 'nullable|string',
        'updated_at' => 'nullable|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function reasons()
    {
        return $this->hasMany(\App\Models\Reason::class, 'place_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'name'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return Place::$searchIn;
    }
}
