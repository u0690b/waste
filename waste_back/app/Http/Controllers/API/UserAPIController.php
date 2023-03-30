<?php

namespace App\Http\Controllers\API;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Register;
use Auth;
use Doctrine\Inflector\Rules\English\Rules;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{

    function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $user = Auth::user();
        //     if (!($user->roles == 'admin' || $user->roles == 'mha' || $user->roles == 'da' || $user->roles == 'zaa')) {
        //         abort(403);
        //     }
        //     return $next($request);
        // });
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /Users
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->all(["search", ...User::$searchIn]);
        $user = Auth::user();
        $input['soum_district_id'] =  $user->soum_district_id;
        switch ($user->roles) {
            case 'mha':
                $input['roles'] = ['mha',  'zaa', 'da'];
                break;
            case 'da':
                $input['roles'] = ['mha',  'hd'];
                break;
            case 'zaa':
                $input['roles'] = ['da',  'mha'];
                break;
            default:
                $input['roles'] = 'null';
                break;
        }


        $roles = User::$rolesModel;
        $query = User::filter($input);
        $query->where('id', '<>', $user->id);
        if ($user->roles == 'mha') {
        }
        if ($request->waste_id) {
            if ($reg = Register::where('id', $request->waste_id)->first()) {
                if ($reg->allocate_by)
                    $query->orWhere('id', '=', $reg->allocate_by);
            }
            switch ($user->roles) {
                case 'hd':

                    break;
                case 'mha':
                    $query->orWhere('roles', '=', 'zaa');
                    $query->orWhere('roles', '=', 'emy');
                    $query->orWhere('roles', '=', 'boajy');
                    $query->orWhere('roles', '=', 'bhby');
                case 'zaa':
                    $query->orWhere('roles', '=', 'da');
                    break;
                case 'bhby':
                    $query->orWhere('roles', '=', 'boajy');
                    break;
                case 'boajy':
                    $query->orWhere('roles', '=', 'bhby');
                    break;
                default:

                    break;
            }


            $input['id'] = ['mha',  'zaa', 'da'];
        }
        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $statuses = $query->get()->map(function ($v) use ($roles) {
            if ($v->roles == 'hd') {
                $name = $v->soum_district->short . ' ' . $v->bag_horoo->name;
            } else {
                $name = $v->name . ' /' . $v->soum_district->short . ' ' . $roles[$v->roles] . '/';
            }
            return array_merge($v->toArray(), ["name" =>  $name]);
        });

        return   $statuses->toJson();
    }

    /**
     * Store a newly created User in storage.
     * POST /usersModels
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->where('roles', '<>', 'none')->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('soum_district:id,name')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => 'Нэвтрэх нэр нууц үг буруу байна',
            ]);
        }

        $user->token = $user->createToken('token')->plainTextToken;

        return  Response::json($user->toArray(), 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Store a newly created User in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = User::$rules;
        $rules['username'] = 'required|string|max:255|unique:' . User::class;
        $rules['password'] = ['required',  \Illuminate\Validation\Rules\Password::defaults()];
        $rules['bag_horoo_id'] = 'nullable';
        $rules['aimag_city_id'] = 'nullable';
        unset($rules['roles']);

        $input =  $request->validate($rules);
        $input['aimag_city_id'] = 7;
        $input['roles'] = 'none';

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->sendUserCreated();
        return true;
    }

    /**
     * Store a newly created User in storage.
     * POST /usersModels
     *
     * @return Response
     */
    public function user(Request $request)
    {
        return  Auth::user()->load('aimag_city:id,name')->load('bag_horoo:id,name')->load('soum_district:id,name');
    }

    /**
     * Store a newly created User in storage.
     * POST /usersModels
     *
     * @return Response
     */
    public function save_token(Request $request)
    {
        $request->validate([
            'push_token' => 'required|string',
        ]);

        Auth::user()->push_token = $request->push_token;
        Auth::user()->save();

        return new JsonResponse('success');
    }
}
