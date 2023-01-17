<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Status
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
 * @method static \Database\Factories\StatusFactory factory(...$parameters)
 * @method static Builder|Status filter(array $filters)
 * @method static Builder|Status newModelQuery()
 * @method static Builder|Status newQuery()
 * @method static Builder|Status query()
 * @method static Builder|Status whereCreatedAt($value)
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereName($value)
 * @method static Builder|Status whereUpdatedAt($value)
 * @mixin \Eloquent
 */


class Industry extends Model
{

    use HasFactory;

    public $table = 'industries';
    public $timestamps = false;
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
     * @param Array $filters
     * @return App\Models\Industry
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, Industry::$searchIn);
        }
        return $query;
    }
}