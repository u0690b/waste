<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Notification
 * @package App\Models
 * @version August 12, 2025, 8:37 pm +08
 *
 * @property \App\Models\User $user
 * @property integer $user_id Хэнээс
 * @property string $type Төрөл
 * @property string $title Гарчиг
 * @property string $content Агуулга
 * @property integer $rid Холоотой айди
 * @property string $read_at Уншсан
 */
class Notification extends Model
{

    use HasFactory;

    use HasFilter;

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
        'read_at' => 'string'
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
        'rid' => 'nullable',
        'read_at' => 'nullable|string',
        'created_at' => 'nullable|string',
        'updated_at' => 'nullable|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return ($this->type=='1')? $this->belongsTo(\App\Models\User::class, 'user_id'): $this->belongsTo(\App\Models\Customer::class, 'user_id');
    }

    /**
     * @var array
     */
    public static $searchIn = [
        'user_id',
        'type',
        'title',
        'content',
        'rid',
        'read_at'
    ];

    /**
     * Filter Model
     *
     * @return array
     */
    public function getSearchIn()
    {
        return Notification::$searchIn;
    }
}
