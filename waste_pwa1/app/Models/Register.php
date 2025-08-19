<?php

namespace App\Models;

use App\Services\FirebaseMessagingService;
use Auth;
use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Log;

/**
 * Class Register
 * @package App\Models
 * @version August 18, 2025, 1:56 am +08
 *
 * @property \App\Models\AimagCity $aimagCity
 * @property \App\Models\User $allocateBy
 * @property \App\Models\BagHoroo $bagHoroo
 * @property \App\Models\User $comfUser
 * @property \App\Models\Reason $reason
 * @property \App\Models\User $regUser
 * @property \App\Models\Resolve $resolve
 * @property \App\Models\SoumDistrict $soumDistrict
 * @property \App\Models\Status $status
 * @property \Illuminate\Database\Eloquent\Collection $attachedFiles
 * @property string $whois Иргэн/ААН
 * @property string $name Байгууллага, аж ахуйн нэгжийн нэр, иргэний овог нэр
 * @property string $register Регистрийн дугаар
 * @property string $chiglel Үйл ажиллагааны чиглэл
 * @property integer $aimag_city_id Аймаг,Нийслэл
 * @property integer $soum_district_id Сум,Дүүрэг
 * @property integer $bag_horoo_id Баг,Хороо
 * @property string $address Хаяг, байршилд
 * @property string $description Гаргасан зөрчлийн байдал
 * @property integer $reason_id Зөрчлийн төрөл
 * @property string $zuil_zaalt Зөрчсөн хууль тогтоомжийн зүйл, заалт
 * @property string $long Уртраг
 * @property string $lat Өргөрөг
 * @property integer $reg_user_id Бүртгэсэн хүн
 * @property integer $resolve_id Шийдвэрийн төрөл
 * @property string $resolve_desc Шийдвэрлэсэн байдал
 * @property string $resolve_image Шийдвэрлэсэн зураг
 * @property string $resolved_at Шийдвэрлэсэн огноо
 * @property integer $comf_user_id Шийдвэрлэсэн хүн
 * @property integer $status_id Төлөв
 * @property string $reg_at Үүсгэсэн
 * @property integer $allocate_by Хуваарилсан хүн
 */
class Register extends Model
{

    use HasFactory;

    use HasFilter;

    public $table = 'registers';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'whois',
        'name',
        'register',
        'chiglel',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'address',
        'description',
        'reason_id',
        'zuil_zaalt',
        'long',
        'lat',
        'reg_user_id',
        'resolve_id',
        'resolve_desc',
        'resolve_image',
        'resolved_at',
        'comf_user_id',
        'status_id',
        'reg_at',
        'allocate_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'whois' => 'string',
        'name' => 'string',
        'register' => 'string',
        'chiglel' => 'string',
        'aimag_city_id' => 'integer',
        'soum_district_id' => 'integer',
        'bag_horoo_id' => 'integer',
        'address' => 'string',
        'description' => 'string',
        'reason_id' => 'integer',
        'zuil_zaalt' => 'string',
        'long' => 'float',
        'lat' => 'float',
        'reg_user_id' => 'integer',
        'resolve_id' => 'integer',
        'resolve_desc' => 'string',
        'resolve_image' => 'string',
        'resolved_at' => 'string',
        'comf_user_id' => 'integer',
        'status_id' => 'integer',
        'reg_at' => 'string',
        'allocate_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'whois' => 'required|string',
        'name' => 'required|string|max:255',
        'register' => 'nullable|string|max:255',
        'chiglel' => 'nullable|string|max:255',
        'aimag_city_id' => 'required',
        'soum_district_id' => 'nullable',
        'bag_horoo_id' => 'nullable',
        'address' => 'nullable|string|max:500',
        'description' => 'required|string|max:2000',
        'reason_id' => 'required',
        'zuil_zaalt' => 'nullable|string|max:1000',
        'long' => 'required|numeric',
        'lat' => 'required|numeric',
        'reg_user_id' => 'nullable',
        'resolve_id' => 'nullable',
        'resolve_desc' => 'nullable|string|max:2000',
        'resolve_image' => 'nullable|string|max:500',
        'resolved_at' => 'nullable|string',
        'comf_user_id' => 'nullable',
        'status_id' => 'nullable',
        'images' => 'sometimes|array',
        'images.*' => 'sometimes|file',
        'video' => 'sometimes|file',
        'reg_at' => 'nullable|string',
        'allocate_by' => 'nullable',
        'created_at' => 'nullable|string',
        'updated_at' => 'nullable|string'
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
    public function allocated()
    {
        return $this->belongsTo(\App\Models\User::class, 'allocate_by');
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
    public function comf_user()
    {
        return $this->belongsTo(\App\Models\User::class, 'comf_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function reason()
    {
        return $this->belongsTo(\App\Models\Reason::class, 'reason_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function reg_user()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'reg_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function resolve()
    {
        return $this->belongsTo(\App\Models\Resolve::class, 'resolve_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function soum_district()
    {
        return $this->belongsTo(\App\Models\SoumDistrict::class, 'soum_district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attachedFiles()
    {
        return $this->hasMany(\App\Models\AttachedFile::class, 'register_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function attached_images()
    {
        return $this->hasMany(\App\Models\AttachedFile::class, 'register_id')->where('type', 'img');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function attached_video()
    {
        return $this->HasOne(\App\Models\AttachedFile::class, 'register_id')->where('type', 'video');
    }
    /**
     * @var array
     */
    public static $searchIn = [
        'name',
        'register',
        'chiglel',
        'aimag_city_id',
        'soum_district_id',
        'bag_horoo_id',
        'address',
        'description',
        'reason_id',
        'zuil_zaalt',
        'long',
        'lat',
        'reg_user_id',
        'resolve_id',
        'resolve_desc',
        'resolve_image',
        'resolved_at',
        'comf_user_id',
        'status_id',
        'reg_at',
        'allocate_by'
    ];

    /**
     * Filter Model
     *
     * @return array
     */
    public function getSearchIn()
    {
        return Register::$searchIn;
    }


    public function sendCreatedWasteNotify()
    {

        $users = User::where('aimag_city_id', $this->aimag_city_id);
        if ($this->aimag_city_id == 7) {
            $users = $users->where('soum_district_id', $this->soum_district_id);
        }

        $users = $users->where('roles', '=', 'da')->get();

        $tokens = $users->whereNotNull('push_token')->pluck('push_token')->toArray();

        foreach ($users as $key => $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => '1',
                'title' => $this->reg_user->lastname . ' ' . $this->reg_user->firstname .'-аас',
                'rid' => $this->id,
                'content' => $this->whois . ' ' . $this->name ." -ны гаргасан зөрчил танд бүртэсэн тухай мэдэгдэл ",
            ]);
        }

        if (count($tokens)) {
            $messagingService = new FirebaseMessagingService();
            foreach ($tokens as $key => $token) {
                $title = 'Шинэ зөрчил бүртгэгдлээ';
                $body = $this->whois . ' ' . $this->name . '-ны гаргасан ' . $this->reason->name . ' зөрчил';
                $customData = [
                    'id' => $this->id,
                    'type' => 'register',
                ];
                $messagingService->sendNotificationToDevice($token, $title, $body, $customData);
            }
        }
    }

}
