<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class IndustryController extends Controller
{
    /**
     * Display a listing of the Industry.
     *
     * @return Response
     */
    public function index()
    {
        $industries = Industry::filter(Request::all(["search", ...Industry::$searchIn]));
        if (Request::has('only')) {
            return json_encode($industries->paginate(Request::input('per_page'),['id', 'name']));
        }
        return Inertia::render('Admin/industries/Index', [
            'filters' => Request::only(["search", ...Industry::$searchIn]),
            'datas' => $industries
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','name')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Industry.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/industries/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Industry in storage.
     *
     * @return Response
     */
    public function store()
    {
        Industry::create(Request::validate(Industry::$rules));
        return Redirect::route('admin.industries.index')->with('success', 'Industry created.');
    }

    /**
     * Show the form for editing the specified Industry.
     *
     * @param Industry $industry
     *
     * @return Response
     */
    public function edit(Industry $industry)
    {
        return Inertia::render('Admin/industries/Edit', [
            'data' =>  $industry,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified Industry in storage.
     *
     * @param Industry $industry
     *
     * @return Response
     */
    public function update(Industry $industry)
    {
        $industry->update(Request::validate(Industry::$rules));
        return Redirect::route('admin.industries.index')->with('success', 'Industry updated.');
    }

    /**
     * Remove the specified Industry from storage.
     *
     * @param Industry $industry
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Industry $industry)
    {
        $industry->delete();
        return Redirect::route('admin.industries.index')->with('success', 'Industry deleted.');
    }
}
