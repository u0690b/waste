<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersModel;
use Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the UsersModel.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $users = UsersModel::filter(Request::all(["search", ...UsersModel::$searchIn]))->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('soum_district:id,name')->with('place:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');

        if (Request::has('only')) {
            return json_encode($users->cursorPaginate(Request::input('per_page'), ['id', 'name']));
        }

        return Inertia::render('Admin/users_models/Index', [
            'filters' => Request::only(["search", ...UsersModel::$searchIn, 'orderBy', 'dir']),
            'datas' => $users
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new UsersModel.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/users_models/Create', ['host' => config('app.url')]);
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
        $user->load('aimag_city:id,name')->load('bag_horoo:id,name')->load('soum_district:id,name')->load('place:id,name');
        return Inertia::render('Admin/users_models/Show', [
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
        $user->load('aimag_city:id,name')->load('bag_horoo:id,name')->load('soum_district:id,name')->load('place:id,name');
        return Inertia::render('Admin/users_models/Edit', [
            'data' => $user,
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
        $user->delete();
        return redirect(Request::header('back') ?? route('admin.users.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
