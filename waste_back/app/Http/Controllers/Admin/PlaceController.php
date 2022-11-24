<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class PlaceController extends Controller
{
    /**
     * Display a listing of the Place.
     *
     * @return Response
     */
    public function index()
    {
        $places = Place::filter(Request::all(["search", ...Place::$searchIn]));
        if (Request::has('only')) {
            return json_encode($places->paginate(Request::input('per_page'),['id', 'name']));
        }
        return Inertia::render('Admin/places/Index', [
            'filters' => Request::only(["search", ...Place::$searchIn]),
            'datas' => $places
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','name')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Place.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/places/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Place in storage.
     *
     * @return Response
     */
    public function store()
    {
        Place::create(Request::validate(Place::$rules));
        return Redirect::route('admin.places.index')->with('success', 'Place created.');
    }

    /**
     * Show the form for editing the specified Place.
     *
     * @param Place $place
     *
     * @return Response
     */
    public function edit(Place $place)
    {
        return Inertia::render('Admin/places/Edit', [
            'data' =>  $place,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified Place in storage.
     *
     * @param Place $place
     *
     * @return Response
     */
    public function update(Place $place)
    {
        $place->update(Request::validate(Place::$rules));
        return Redirect::route('admin.places.index')->with('success', 'Place updated.');
    }

    /**
     * Remove the specified Place from storage.
     *
     * @param Place $place
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return Redirect::route('admin.places.index')->with('success', 'Place deleted.');
    }
}
