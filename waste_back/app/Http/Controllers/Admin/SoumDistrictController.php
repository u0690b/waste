<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SoumDistrict;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class SoumDistrictController extends Controller
{
    /**
     * Display a listing of the SoumDistrict.
     *
     * @return Response
     */
    public function index()
    {
        $soumDistricts = SoumDistrict::filter(Request::all(["search", ...SoumDistrict::$searchIn]))->with('aimag_city:id,name');
        if (Request::has('only')) {
            return json_encode($soumDistricts->paginate(Request::input('per_page'),['id', 'name']));
        }
        return Inertia::render('Admin/soum_districts/Index', [
            'filters' => Request::only(["search", ...SoumDistrict::$searchIn]),
            'datas' => $soumDistricts
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','code','name','aimag_city','aimag_city_id')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new SoumDistrict.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/soum_districts/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created SoumDistrict in storage.
     *
     * @return Response
     */
    public function store()
    {
        SoumDistrict::create(Request::validate(SoumDistrict::$rules));
        return Redirect::route('admin.soum_districts.index')->with('success', 'SoumDistrict created.');
    }

    /**
     * Show the form for editing the specified SoumDistrict.
     *
     * @param SoumDistrict $soumDistrict
     *
     * @return Response
     */
    public function edit(SoumDistrict $soumDistrict)
    {
        return Inertia::render('Admin/soum_districts/Edit', [
            'data' =>  $soumDistrict,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified SoumDistrict in storage.
     *
     * @param SoumDistrict $soumDistrict
     *
     * @return Response
     */
    public function update(SoumDistrict $soumDistrict)
    {
        $soumDistrict->update(Request::validate(SoumDistrict::$rules));
        return Redirect::route('admin.soum_districts.index')->with('success', 'SoumDistrict updated.');
    }

    /**
     * Remove the specified SoumDistrict from storage.
     *
     * @param SoumDistrict $soumDistrict
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(SoumDistrict $soumDistrict)
    {
        $soumDistrict->delete();
        return Redirect::route('admin.soum_districts.index')->with('success', 'SoumDistrict deleted.');
    }
}
