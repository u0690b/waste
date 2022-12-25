<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class LegalEntity
 *
 * @package App\Models
 * @version November 24, 2022, 7:41 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property string $name
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @method static \Database\Factories\LegalEntityFactory factory(...$parameters)
 * @method static Builder|LegalEntity filter(array $filters)
 * @method static Builder|LegalEntity newModelQuery()
 * @method static Builder|LegalEntity newQuery()
 * @method static Builder|LegalEntity query()
 * @method static Builder|LegalEntity whereCreatedAt($value)
 * @method static Builder|LegalEntity whereId($value)
 * @method static Builder|LegalEntity whereName($value)
 * @method static Builder|LegalEntity whereUpdatedAt($value)
 * @mixin \Eloquent
 */


class LegalEntity extends Model
{

    use HasFactory;
    public $timestamps = false;
    public $table = 'legal_entity';






    public $fillable = [
        'register',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'register'=>'string',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'register' => 'required|string|max:10',
        'name' => 'required|string|max:1000',
      
    ];

    
    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'register'
    ];

    /**
     * Filter Model
     * @param Array $filters
     * @return App\Models\LegalEntity
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, LegalEntity::$searchIn);
        }
        return $query;
    }
}