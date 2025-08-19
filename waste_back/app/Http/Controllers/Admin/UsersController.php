<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\User;
use App\Models\UsersModel;
use Auth;
use Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Response;

class UsersController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!($user->roles == 'admin' || $user->roles == 'da')) {
                abort(403);
            }

            return $next($request);
        });
    }
    private function guard(UsersModel $user)
    {

        $cur_user = Auth::user();
        if ($cur_user->roles != 'admin') {
            if (!($user->roles == 'mha'))
                abort(403, message: 'Та зөвхөн өөрийн дүүргийн хэрэглэгчийн мэдээллийг харах боломжтой.');
            if (!($cur_user->aimag_city_id == 7 && $user->soum_district_id == $cur_user->soum_district_id))
                abort(403, message: 'Та зөвхөн өөрийн дүүргийн хэрэглэгчийн мэдээллийг харах боломжтой.');
            elseif (!($cur_user->aimag_city_id == $user->aimag_city_id))
                abort(403, message: 'Та зөвхөн өөрийн аймгийн хэрэглэгчийн мэдээллийг харах боломжтой.');
        }
    }
    /**
     *
     * Display a listing of the UsersModel.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {

        $user = Auth::user();
        $input = Request::all(["search", ...UsersModel::$searchIn]);

        if ($user->roles != 'admin') {
            if ($user->aimag_city_id == 7)
                $input['soum_district_id'] = $user->soum_district_id;
            $input['aimag_city_id'] = $user->aimag_city_id;
        }
        if (!$input['roles']) {
            //$input['roles'] = 'none';
        }
        if ($user->roles != 'admin') {
            $input['roles'] = ['mha'];
        }


        $users = UsersModel::filter($input)
            ->with('aimag_city:id,name')
            ->with('bag_horoo:id,name')
            ->with('soum_district:id,name')
            ->with('place:id,name')
            ->orderBy(Request::input('orderBy') ?? 'roles', Request::input('dir') ?? 'asc');



        if (Request::has('only')) {
            return json_encode($users->cursorPaginate(Request::input('per_page'), ['id', 'name']));
        }

        return Inertia::render('Admin/users_models/Index', [
            'filters' => [
                ...Request::only(["search", ...UsersModel::$searchIn, 'orderBy', 'dir']),
                ...$user->roles != 'admin' ? ['aimag_city_id' => $user->aimag_city_id] : [],
                ...$user->roles != 'admin' && $user->aimag_city_id == 7 ? ['soum_district_id' => $user->soum_district_id] : [],
            ],
            'datas' => $users
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
            'places' => Place::all(),
        ]);
    }

    /**
     * Show the form for creating a new UsersModel.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/users_models/Create', [
            'aimag_city' => Auth::user()->aimag_city,
            'soum_district' => Auth::user()->soum_district,
            'host' => config('app.url')
        ]);
    }

    /**
     * Store a newly created UsersModel in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = UsersModel::$rules;
        $rule['username'] = 'required|string|max:255|unique:' . User::class;
        $rule['password'] = ['required', Password::defaults()];
        $rule['bag_horoo_id'] = 'nullable';

        $input = Request::validate($rule);


        $input['password'] = Hash::make($input['password']);
        $user = UsersModel::create($input);

        return redirect(Request::header('back') ?? route('admin.users.show', $user->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param UsersModel $user
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(UsersModel $user)
    {
        $this->guard($user);
        $user->load('aimag_city:id,name')->load('bag_horoo:id,name')->load('soum_district:id,name')->load('place:id,name');
        return Inertia::render('Admin/users_models/Show', [
            'aimag_city' => Auth::user()->aimag_city,
            'soum_district' => Auth::user()->soum_district,
            'data' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified UsersModel.
     *
     * @param UsersModel $user
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(UsersModel $user)
    {
        $this->guard($user);
        $user->load('aimag_city:id,name')->load('bag_horoo:id,name')->load('soum_district:id,name')->load('place:id,name');
        return Inertia::render('Admin/users_models/Edit', [
            'data' => $user,
            'aimag_city' => Auth::user()->aimag_city,
            'soum_district' => Auth::user()->soum_district,
        ]);
    }

    /**
     * Update the specified UsersModel in storage.
     *
     * @param UsersModel $user
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(UsersModel $user)
    {
        $this->guard($user);
        $rule = UsersModel::$rules;
        unset($rule['username']);
        $rule['password'] = 'sometimes';

        $input = Request::validate($rule);
        if (isset($input['password']))
            $input['password'] = Hash::make($input['password']);
        $user->update($input);

        return redirect(Request::header('back') ?? route('admin.users.show', $user->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified UsersModel from storage.
     *
     * @param UsersModel $user
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(UsersModel $user)
    {
        $this->guard($user);
        $user->delete();
        return redirect(Request::header('back') ?? route('admin.users.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
