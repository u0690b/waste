<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AttachedFile
 * @package App\Models
 * @version November 24, 2022, 2:55 pm UTC
 *
 * @property string $path
 * @property string $type
 */
class AttachedFile extends Model
{

    use HasFactory;

    public $table = 'attached_files';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'path',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'path' => 'string',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'path' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    

    /**
     * @var array
     */
    public static $searchIn = [
        'path',
        'type'
    ];

    /**
    * Filter Model
    * param Array $filters
    * return AttachedFile
    */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            foreach ($filters as $key => $value) {
                if (! $value) {
                    continue;
                }
                if ($key === 'search') {
                    $this->buildSearch($query, $filters['search'] ?? '', AttachedFile::$searchIn);
                } elseif (is_array($value)) {
                    $query = $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }
    }
}
