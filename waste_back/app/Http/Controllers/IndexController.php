<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Register;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class IndexController extends Controller
{
    /**
     * Display a listing of the Register.
     *
     * @return Response
     */
    public function index()
    {
        $registers = Register::filter(Request::all(["search", ...Register::$searchIn]))
            ->with('aimag_city:id,name')
            ->with('bag_horoo:id,name')
            ->with('comf_user:id,name')
            ->with('reason:id,name')
            ->with('reg_user:id,name')
            ->with('soum_district:id,name')
            ->with('status:id,name')
            ->with('attached_images:id,register_id,path')
            ->with('attached_video:id,register_id,path');
        if (Request::has('only')) {
            return json_encode($registers->paginate(Request::input('per_page'), ['id', 'name']));
        }
        return Inertia::render('Admin/registers/Index', [
            'filters' => Request::only(["search", ...Register::$searchIn]),
            'datas' => $registers
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id', 'name', 'register', 'chiglel', 'aimag_city', 'aimag_city_id', 'soum_district', 'soum_district_id', 'bag_horoo', 'bag_horoo_id', 'address', 'description', 'reason', 'reason_id', 'zuil_zaalt', 'resolve_desc', 'long', 'lat', 'reg_user', 'reg_user_id', 'comf_user', 'comf_user_id', 'status', 'status_id')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Register.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/registers/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Register in storage.
     *
     * @return Response
     */
    public function store()
    {
        Register::create(Request::validate(Register::$rules));
        return Redirect::route('admin.registers.index')->with('success', 'Register created.');
    }

    /**
     * Show the form for editing the specified Register.
     *
     * @param Register $register
     *
     * @return Response
     */
    public function edit(Register $register)
    {
        return Inertia::render('Admin/registers/Edit', [
            'data' =>  $register,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified Register in storage.
     *
     * @param Register $register
     *
     * @return Response
     */
    public function update(Register $register)
    {
        $register->update(Request::validate(Register::$rules));
        return Redirect::route('admin.registers.index')->with('success', 'Register updated.');
    }

    /**
     * Remove the specified Register from storage.
     *
     * @param Register $register
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Register $register)
    {
        $register->delete();
        return Redirect::route('admin.registers.index')->with('success', 'Register deleted.');
    }
}
