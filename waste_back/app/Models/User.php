<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\FirebaseMessagingService;
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
class User extends UsersModel implements
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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'push_token',
    ];





    public static $rolesModel = [
        "admin" => "Админ",
        "zaa" => "Захирагчийн ажлын алба",
        "mha" => "МХ байцаагч",
        "da" => "Дүүргийн ЗДТГ",
        "hd" => "Хорооны засаг дарга",
        "onb" => "Олон нийтийн байцаагч",
        "boajy" => "Байгаль орчин, аялал жуулчлалын яам",
        "bhby" => "Барилга, хот байгуулалтын яам",
        "emy" => "Эрүүл мэндийн яам",
        "none" => "Идэвхигүй",
    ];



    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'username',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'phone',
        'place_id',
        'roles'
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
     * @return void
     */
    public function sendUserCreated()
    {
        Notification::create([
            'user_id' => $this->id,
            'type' => 'user',
            'title' => 'Тавтай морил',
            'content' => 'Шинэ хэрэглэгч бүртгэгдсэн',
        ]);

        $users = User::whereSoumDistrictId($this->soum_district_id)
            ->whereIn('roles', ['da', 'zaa'])
            ->get();
        $tokens = $users->whereNotNull('push_token')->pluck('push_token')->toArray();


        foreach ($users as $key => $user) {

            Notification::create([
                'user_id' => $user->id,
                'type' => 'user',
                'title' => 'Шинэ хэрэглэгч бүртгэгдсэн',
                'content' => $this->name . ' /' . $this->username . '/ шинэ хэрэглэгч',
            ]);
        }


        if (count($tokens)) {
            $messagingService = new FirebaseMessagingService();
            foreach ($tokens as $key => $token) {
                $title = 'Зөрчил шийдвэрлэгдлээ';
                $body = $this->name . ' /' . $this->username . '/ шинэ хэрэглэгч';
                $customData = [
                    'id' => $this->id,
                    'type' => 'register',
                ];
                $messagingService->sendNotificationToDevice($token, $title, $body, $customData);
            }
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
