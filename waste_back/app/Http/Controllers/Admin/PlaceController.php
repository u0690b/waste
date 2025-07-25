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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $places = Place::filter(Request::all(["search", ...Place::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($places->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/places/Index', [
            'filters' => Request::only(["search", ...Place::$searchIn, 'orderBy', 'dir']),
            'datas' => $places
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Place.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/places/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Place in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Place::$rules;
        $input =  Request::validate($rule);
        $place = Place::create($input);
        return redirect(Request::header('back') ?? route('admin.places.show', $place->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Place $place
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Place $place)
    {
        $place;
        return Inertia::render('Admin/places/Show', [
            'data' =>  $place,
        ]);
    }

    /**
     * Show the form for editing the specified Place.
     *
     * @param Place $place
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Place $place)
    {
        $place;
        return Inertia::render('Admin/places/Edit', [
            'data' =>  $place,
        ]);
    }

    /**
     * Update the specified Place in storage.
     *
     * @param Place $place
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Place $place)
    {
        $rule = Place::$rules;
        $input =  Request::validate($rule);
        $place->update($input);
        
        return redirect(Request::header('back') ?? route('admin.places.show', $place->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Place from storage.
     *
     * @param Place $place
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Place $place)
    {
        $place->delete();
        return redirect(Request::header('back') ?? route('admin.places.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
