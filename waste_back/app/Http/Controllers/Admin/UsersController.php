<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the User.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::filter(Request::all(["search", ...User::$searchIn]))->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('soum_district:id,name');
        if (Request::has('only')) {
            return json_encode($users->paginate(Request::input('per_page'), ['id', 'name']));
        }
        return Inertia::render('Admin/users_models/Index', [
            'filters' => Request::only(["search", ...User::$searchIn]),
            'datas' => $users
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->toArray(),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/users_models/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created User in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = User::$rules;
        $rules['username'] = 'required|string|max:255|unique:' . User::class;
        $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        $input = Request::validate($rules);

        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return Redirect::route('admin.users.index')->with('success', 'User created.');
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param User $user
     *
     * @return Response
     */
    public function edit(User $user)
    {
        $user->load('aimag_city:id,name')->load('bag_horoo:id,name')->load('soum_district:id,name');
        return Inertia::render('Admin/users_models/Edit', [
            'data' =>  $user,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param User $user
     *
     * @return Response
     */
    public function update(User $user)
    {
        $rules = User::$rules;
        unset($rules['username']);
        $rules['password'] = 'sometimes';
        $input = Request::validate($rules);
        if (isset($input['password']))
            $input['password'] = Hash::make($input['password']);
        $user->update($input);
        return Redirect::route('admin.users.index')->with('success', 'User updated.');
    }

    /**
     * Remove the specified User from storage.
     *
     * @param User $user
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::route('admin.users.index')->with('success', 'User deleted.');
    }
}
