<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class AimagCity
 *
 * @package App\Models
 * @version November 24, 2022, 7:40 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property \Illuminate\Database\Eloquent\Collection $soumDistricts
 * @property string $code
 * @property string $name
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @property-read int|null $soum_districts_count
 * @property-read int|null $users_count
 * @method static \Database\Factories\AimagCityFactory factory(...$parameters)
 * @method static Builder|AimagCity filter(array $filters)
 * @method static Builder|AimagCity newModelQuery()
 * @method static Builder|AimagCity newQuery()
 * @method static Builder|AimagCity query()
 * @method static Builder|AimagCity whereCode($value)
 * @method static Builder|AimagCity whereCreatedAt($value)
 * @method static Builder|AimagCity whereId($value)
 * @method static Builder|AimagCity whereName($value)
 * @method static Builder|AimagCity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AimagCity extends \Eloquent {}
}

namespace App\Models{
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
	class AttachedFile extends \Eloquent {}
}

namespace App\Models{
/**
 * Class BagHoroo
 *
 * @package App\Models
 * @version November 24, 2022, 7:40 pm UTC
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property string $code
 * @property string $name
 * @property integer $soum_district_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @property-read \App\Models\SoumDistrict $soum_district
 * @property-read int|null $users_count
 * @method static \Database\Factories\BagHorooFactory factory(...$parameters)
 * @method static Builder|BagHoroo filter(array $filters)
 * @method static Builder|BagHoroo newModelQuery()
 * @method static Builder|BagHoroo newQuery()
 * @method static Builder|BagHoroo query()
 * @method static Builder|BagHoroo whereCode($value)
 * @method static Builder|BagHoroo whereCreatedAt($value)
 * @method static Builder|BagHoroo whereId($value)
 * @method static Builder|BagHoroo whereName($value)
 * @method static Builder|BagHoroo whereSoumDistrictId($value)
 * @method static Builder|BagHoroo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BagHoroo extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Place
 *
 * @package App\Models
 * @version November 24, 2022, 7:41 pm UTC
 * @property \Illuminate\Database\Eloquent\Collection $reasons
 * @property string $name
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $reasons_count
 * @method static \Database\Factories\PlaceFactory factory(...$parameters)
 * @method static Builder|Place filter(array $filters)
 * @method static Builder|Place newModelQuery()
 * @method static Builder|Place newQuery()
 * @method static Builder|Place query()
 * @method static Builder|Place whereCreatedAt($value)
 * @method static Builder|Place whereId($value)
 * @method static Builder|Place whereName($value)
 * @method static Builder|Place whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Place extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Reason
 *
 * @package App\Models
 * @version November 24, 2022, 7:41 pm UTC
 * @property \App\Models\Place $place
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property string $name
 * @property integer $place_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @method static \Database\Factories\ReasonFactory factory(...$parameters)
 * @method static Builder|Reason filter(array $filters)
 * @method static Builder|Reason newModelQuery()
 * @method static Builder|Reason newQuery()
 * @method static Builder|Reason query()
 * @method static Builder|Reason whereCreatedAt($value)
 * @method static Builder|Reason whereId($value)
 * @method static Builder|Reason whereName($value)
 * @method static Builder|Reason wherePlaceId($value)
 * @method static Builder|Reason whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Reason extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Register
 *
 * @package App\Models
 * @version November 24, 2022, 7:41 pm UTC
 * @property \App\Models\AimagCity $aimagCity
 * @property \App\Models\BagHoroo $bagHoroo
 * @property \App\Models\Reason $reason
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \App\Models\Status $status
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property number $long
 * @property number $lat
 * @property string $description
 * @property string $resolve_desc
 * @property integer $reason_id
 * @property integer $status_id
 * @property integer $aimag_city_id
 * @property integer $soum_district_id
 * @property integer $bag_horoo_id
 * @property string $address
 * @property integer $user_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AimagCity $aimag_city
 * @property-read \App\Models\BagHoroo $bag_horoo
 * @property-read int|null $register_histories_count
 * @property-read \App\Models\SoumDistrict $soum_district
 * @method static \Database\Factories\RegisterFactory factory(...$parameters)
 * @method static Builder|Register filter(array $filters)
 * @method static Builder|Register newModelQuery()
 * @method static Builder|Register newQuery()
 * @method static Builder|Register query()
 * @method static Builder|Register whereAddress($value)
 * @method static Builder|Register whereAimagCityId($value)
 * @method static Builder|Register whereBagHorooId($value)
 * @method static Builder|Register whereCreatedAt($value)
 * @method static Builder|Register whereDescription($value)
 * @method static Builder|Register whereId($value)
 * @method static Builder|Register whereLat($value)
 * @method static Builder|Register whereLong($value)
 * @method static Builder|Register whereReasonId($value)
 * @method static Builder|Register whereResolveDesc($value)
 * @method static Builder|Register whereSoumDistrictId($value)
 * @method static Builder|Register whereStatusId($value)
 * @method static Builder|Register whereUpdatedAt($value)
 * @method static Builder|Register whereUserId($value)
 * @mixin \Eloquent
 */
	class Register extends \Eloquent {}
}

namespace App\Models{
/**
 * Class RegisterHistory
 *
 * @package App\Models
 * @version November 24, 2022, 7:42 pm UTC
 * @property \App\Models\AimagCity $aimagCity
 * @property \App\Models\BagHoroo $bagHoroo
 * @property \App\Models\Reason $reason
 * @property \App\Models\Register $register
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \App\Models\Status $status
 * @property \App\Models\User $user
 * @property integer $register_id
 * @property number $long
 * @property number $lat
 * @property string $description
 * @property string $resolve_desc
 * @property integer $reason_id
 * @property integer $status_id
 * @property integer $aimag_city_id
 * @property integer $soum_district_id
 * @property integer $bag_horoo_id
 * @property string $address
 * @property integer $user_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AimagCity $aimag_city
 * @property-read \App\Models\BagHoroo $bag_horoo
 * @property-read \App\Models\SoumDistrict $soum_district
 * @method static \Database\Factories\RegisterHistoryFactory factory(...$parameters)
 * @method static Builder|RegisterHistory filter(array $filters)
 * @method static Builder|RegisterHistory newModelQuery()
 * @method static Builder|RegisterHistory newQuery()
 * @method static Builder|RegisterHistory query()
 * @method static Builder|RegisterHistory whereAddress($value)
 * @method static Builder|RegisterHistory whereAimagCityId($value)
 * @method static Builder|RegisterHistory whereBagHorooId($value)
 * @method static Builder|RegisterHistory whereCreatedAt($value)
 * @method static Builder|RegisterHistory whereDescription($value)
 * @method static Builder|RegisterHistory whereId($value)
 * @method static Builder|RegisterHistory whereLat($value)
 * @method static Builder|RegisterHistory whereLong($value)
 * @method static Builder|RegisterHistory whereReasonId($value)
 * @method static Builder|RegisterHistory whereRegisterId($value)
 * @method static Builder|RegisterHistory whereResolveDesc($value)
 * @method static Builder|RegisterHistory whereSoumDistrictId($value)
 * @method static Builder|RegisterHistory whereStatusId($value)
 * @method static Builder|RegisterHistory whereUpdatedAt($value)
 * @method static Builder|RegisterHistory whereUserId($value)
 * @mixin \Eloquent
 */
	class RegisterHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SoumDistrict
 *
 * @package App\Models
 * @version November 24, 2022, 7:40 pm UTC
 * @property \App\Models\AimagCity $aimagCity
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property \Illuminate\Database\Eloquent\Collection $bagHoroos
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property string $code
 * @property string $name
 * @property integer $aimag_city_id
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AimagCity $aimag_city
 * @property-read int|null $bag_horoos_count
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @property-read int|null $users_count
 * @method static \Database\Factories\SoumDistrictFactory factory(...$parameters)
 * @method static Builder|SoumDistrict filter(array $filters)
 * @method static Builder|SoumDistrict newModelQuery()
 * @method static Builder|SoumDistrict newQuery()
 * @method static Builder|SoumDistrict query()
 * @method static Builder|SoumDistrict whereAimagCityId($value)
 * @method static Builder|SoumDistrict whereCode($value)
 * @method static Builder|SoumDistrict whereCreatedAt($value)
 * @method static Builder|SoumDistrict whereId($value)
 * @method static Builder|SoumDistrict whereName($value)
 * @method static Builder|SoumDistrict whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SoumDistrict extends \Eloquent {}
}

namespace App\Models{
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
	class Status extends \Eloquent {}
}

namespace App\Models{
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
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * Class UsersModel
 *
 * @package App\Models
 * @version November 25, 2022, 1:42 pm UTC
 * @property \App\Models\AimagCity $aimagCity
 * @property \App\Models\BagHoroo $bagHoroo
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \Illuminate\Database\Eloquent\Collection $registers
 * @property \Illuminate\Database\Eloquent\Collection $registerHistories
 * @property string $name
 * @property string $username
 * @property string $password
 * @property integer $aimag_city_id
 * @property integer $soum_district_id
 * @property integer $bag_horoo_id
 * @property string $roles
 * @property string $remember_token
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AimagCity $aimag_city
 * @property-read \App\Models\BagHoroo $bag_horoo
 * @property-read int|null $register_histories_count
 * @property-read int|null $registers_count
 * @property-read \App\Models\SoumDistrict $soum_district
 * @method static \Database\Factories\UsersModelFactory factory(...$parameters)
 * @method static Builder|UsersModel filter(array $filters)
 * @method static Builder|UsersModel newModelQuery()
 * @method static Builder|UsersModel newQuery()
 * @method static Builder|UsersModel query()
 * @method static Builder|UsersModel whereAimagCityId($value)
 * @method static Builder|UsersModel whereBagHorooId($value)
 * @method static Builder|UsersModel whereCreatedAt($value)
 * @method static Builder|UsersModel whereId($value)
 * @method static Builder|UsersModel whereName($value)
 * @method static Builder|UsersModel wherePassword($value)
 * @method static Builder|UsersModel whereRememberToken($value)
 * @method static Builder|UsersModel whereRoles($value)
 * @method static Builder|UsersModel whereSoumDistrictId($value)
 * @method static Builder|UsersModel whereUpdatedAt($value)
 * @method static Builder|UsersModel whereUsername($value)
 * @mixin \Eloquent
 */
	class UsersModel extends \Eloquent {}
}

