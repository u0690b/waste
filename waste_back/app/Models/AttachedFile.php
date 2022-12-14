<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AttachedFile
 * @package App\Models
 * @version December 13, 2022, 9:42 pm UTC
 *
 * @property \App\Models\Register $register
 * @property integer $register_id
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
        'register_id',
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
        'register_id' => 'integer',
        'path' => 'string',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'register_id' => 'required',
        'path' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function register()
    {
        return $this->belongsTo(\App\Models\Register::class, 'register_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'register_id',
        'path',
        'type'
    ];

    /**
    * Filter Model
    * @param Array $filters
    * @return App\Models\AttachedFile
    */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $this->buildFilter($query, $filters, AttachedFile::$searchIn);
        }
        return $this;
    }
}
