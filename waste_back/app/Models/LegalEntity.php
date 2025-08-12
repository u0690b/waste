<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LegalEntity
 * @package App\Models
 * @version August 12, 2025, 9:05 pm +08
 *
 * @property string $register Хуулийн этгээдийн регистр
 * @property string $name Хуулийн этгээдийн нэр
 * @property string $industry Үйл ажиллагааны чиглэл
 */
class LegalEntity extends Model
{

    use HasFactory;

    use HasFilter;

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
        'register',
        'name',
        'industry'
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return LegalEntity::$searchIn;
    }
}
