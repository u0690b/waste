<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AttachedFile
 *
 * @package App\Models
 * @version November 24, 2022, 7:41 pm UTC
 * @property string $path
 * @property string $type
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\AttachedFileFactory factory(...$parameters)
 * @method static Builder|AttachedFile filter(array $filters)
 * @method static Builder|AttachedFile newModelQuery()
 * @method static Builder|AttachedFile newQuery()
 * @method static Builder|AttachedFile query()
 * @method static Builder|AttachedFile whereCreatedAt($value)
 * @method static Builder|AttachedFile whereId($value)
 * @method static Builder|AttachedFile wherePath($value)
 * @method static Builder|AttachedFile whereType($value)
 * @method static Builder|AttachedFile whereUpdatedAt($value)
 * @mixin \Eloquent
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
