<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\FCMService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property int $aimag_city_id
 * @property int $soum_district_id
 * @property int $bag_horoo_id
 * @property mixed $roles
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAimagCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBagHorooId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSoumDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 * @property-read \App\Models\AimagCity $aimag_city
 * @property-read \App\Models\BagHoroo $bag_horoo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RegisterHistory[] $registerHistories
 * @property-read int|null $register_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Register[] $registers
 * @property-read int|null $registers_count
 * @property-read \App\Models\SoumDistrict $soum_district
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(array $filters)
 */
class User extends Model  implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use HasApiTokens, HasFactory, Notifiable, HasFilter, SoftDeletes;
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'name',
        'username',
        'phone',
        'password',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'roles',
        'push_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'push_token',
    ];



    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'phone' => 'string',
        'username' => 'string',
        'aimag_city_id' => 'integer',
        'soum_district_id' => 'integer',
        'bag_horoo_id' => 'integer',
        'roles' => 'json',
        'push_token' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'phone' => 'required|string|max:12',
        'password' => 'required|string|max:255',
        'aimag_city_id' => 'required',
        'soum_district_id' => 'required',
        'bag_horoo_id' => 'required',
        'roles' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'push_token' => 'nullable',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function aimag_city()
    {
        return $this->belongsTo(\App\Models\AimagCity::class, 'aimag_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function bag_horoo()
    {
        return $this->belongsTo(\App\Models\BagHoroo::class, 'bag_horoo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function soum_district()
    {
        return $this->belongsTo(\App\Models\SoumDistrict::class, 'soum_district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registers()
    {
        return $this->hasMany(\App\Models\Register::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function registerHistories()
    {
        return $this->hasMany(\App\Models\RegisterHistory::class, 'user_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id');
    }


    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'username',
        'phone',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'roles',
    ];

    /**
     * Filter Model
     * 
     * @return array
     */
    public function getSearchIn()
    {
        return UsersModel::$searchIn;
    }

    /**
     * Filter Model
     * 
     * @return array
     */
    public function sendUserCreated()
    {
        Notification::create([
            'user_id' => $this->id,
            'type' => 'user',
            'title' => 'Тавай морил',
            'content' =>  'Шинэ хэргэлэгч бүргэгдсэн',
        ]);

        $users = User::whereSoumDistrictId($this->soum_district_id)
            ->whereIn('roles', ['mha', 'da', 'zaa'])
            ->get();
        $tokens = $users->whereNotNull('push_token')->pluck('push_token')->toArray();


        foreach ($users as $key => $user) {

            Notification::create([
                'user_id' => $user->id,
                'type' => 'user',
                'title' => 'Шинэ хэргэлэгч бүргэгдсэн',
                'content' =>   $this->name . ' /' . $this->username . '/ шинэ хэрэглэгч',
            ]);
        }


        if (count($tokens)) {
            FCMService::send(
                $tokens,
                [
                    'title' => 'Зөрчил шийдвэрлэгдлээ',
                    'body' =>   $this->name . ' /' . $this->username . '/ шинэ хэрэглэгч',
                ],
                [
                    'id' => $this->id,
                ]
            );
        }
    }

    /**
     * Filter Model
     * @param Array $filters
     * @return App\Models\Register
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if (count($filters)) {
            $query = $this->buildFilter($query, $filters, UsersModel::$searchIn);
        }
        return $query;
    }
}
