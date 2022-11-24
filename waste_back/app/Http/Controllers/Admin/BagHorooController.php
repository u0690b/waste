<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BagHoroo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class BagHorooController extends Controller
{
    /**
     * Display a listing of the BagHoroo.
     *
     * @return Response
     */
    public function index()
    {
        $bagHoroos = BagHoroo::filter(Request::all(["search", ...BagHoroo::$searchIn]))->with('soum_district:id,name')->paginate();
        if (Request::has('only')) {
            return json_encode($bagHoroos->only('id', 'name'));
        }
        return Inertia::render('Admin/bag_horoos/Index', [
            'filters' => Request::only(["search", ...BagHoroo::$searchIn]),
            'datas' => $bagHoroos
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','code','name','soum_district','soum_district_id')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new BagHoroo.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/bag_horoos/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created BagHoroo in storage.
     *
     * @return Response
     */
    public function store()
    {
        BagHoroo::create(Request::validate(BagHoroo::$rules));
        return Redirect::route('admin.bag_horoos.index')->with('success', 'BagHoroo created.');
    }

    /**
     * Show the form for editing the specified BagHoroo.
     *
     * @param BagHoroo $bagHoroo
     *
     * @return Response
     */
    public function edit(BagHoroo $bagHoroo)
    {
        return Inertia::render('Admin/bag_horoos/Edit', [
            'data' =>  $bagHoroo,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified BagHoroo in storage.
     *
     * @param BagHoroo $bagHoroo
     *
     * @return Response
     */
    public function update(BagHoroo $bagHoroo)
    {
        $bagHoroo->update(Request::validate(BagHoroo::$rules));
        return Redirect::route('admin.bag_horoos.index')->with('success', 'BagHoroo updated.');
    }

    /**
     * Remove the specified BagHoroo from storage.
     *
     * @param BagHoroo $bagHoroo
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(BagHoroo $bagHoroo)
    {
        $bagHoroo->delete();
        return Redirect::route('admin.bag_horoos.index')->with('success', 'BagHoroo deleted.');
    }
}
