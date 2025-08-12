<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Industry
 * @package App\Models
 * @version August 12, 2025, 8:52 pm +08
 *
 * @property string $name Үйл ажиллагааны чиглэл
 */
class Industry extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'industries';
    
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
        return Industry::$searchIn;
    }
}
