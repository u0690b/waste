<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BagHoroo;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!($user->roles == 'admin' || $user->roles == 'mha' || $user->roles == 'da' || $user->roles == 'zaa')) {
                abort(403);
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the User.
     *
     * @return Response
     */
    public function index()
    {
        $input = Request::all(["search", ...User::$searchIn]);
        $user = Auth::user();

        if (!($user->roles == 'admin' || $user->roles == 'zaa')) {
            $input['soum_district_id'] = $user->soum_district_id;
        }
        if (!$input['roles']) {
            $input['roles'] = 'none';
        }
        if ($user->roles == 'mha') {
            $input['roles'] = ['mha',  'zaa', 'da'];
        }
        $users = User::filter($input)->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('soum_district:id,name');

        if (Request::has('only')) {
            return json_encode($users->paginate(Request::input('per_page'), ['id', 'name']));
        }
        return Inertia::render('Admin/users_models/Index', [
            'filters' =>  $input,
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
        return Inertia::render('Admin/users_models/Create', [
            'host' => config('app.url'),
            'aimag_city' => Auth::user()->aimag_city,
            'soum_district' => Auth::user()->soum_district,
        ]);
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
        $rules['bag_horoo_id'] = 'nullable';

        $input = Request::validate($rules);
        if ($input['roles'] == 'mha' || $input['roles'] == 'da') {
            if (!$input['bag_horoo_id']) {
                $input['bag_horoo_id'] = BagHoroo::whereSoumDistrictId($input['soum_district_id'])->first()->id;
            }
        } else {
            Request::validate([
                'bag_horoo_id' => 'required',
            ]);
        }



        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->sendUserCreated();
        return Redirect::route('admin.users.index')->with('success', 'Хэрэглэгчийг амжилттай бүртгэлээ.');
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
            'aimag_city' => Auth::user()->aimag_city,
            'soum_district' => Auth::user()->soum_district,
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
        return Redirect::route('admin.users.index')->with('success', 'Хэрэглэгчийг амжилттай заслаа.');
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
        return Redirect::back()->with('success', 'Хэрэглэгчийг идэвхигүй болголоо.');
    }
}
