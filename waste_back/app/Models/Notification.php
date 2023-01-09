<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Notification
 * @package App\Models
 * @version January 4, 2023, 12:36 am +08
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property string $type
 * @property string $title
 * @property string $content
 * @property string|\Carbon\Carbon $read_at
 */
class Notification extends Model
{

    use HasFactory;

    public $table = 'notifications';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'user_id',
        'type',
        'title',
        'content',
        'rid',
        'read_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'type' => 'string',
        'title' => 'string',
        'content' => 'string',
        'rid' => 'integer',
        'read_at' => 'date:Y-m-d H:i:s',
        'created_at' => 'date:Y-m-d H:i:s',
    ];


    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'type' => 'required|string|max:100',
        'title' => 'required|string|max:500',
        'content' => 'nullable|string',
        'rid' => 'nullable|integer',
        'read_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'user_id',
        'type',
        'title',
        'content',
        'read_at'
    ];

    /**
     * Filter Model
     * @param Array $filters
     * @return App\Models\Notification
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $query =  $this->buildFilter($query, $filters, Notification::$searchIn);
        }
        return $query;
    }
}
