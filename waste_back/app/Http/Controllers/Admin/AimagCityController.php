<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AimagCity;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class AimagCityController extends Controller
{

    public function index()
    {
        $aimagCities = AimagCity::filter(Request::all(["search", ...AimagCity::$searchIn]));
        if (Request::has('only')) {
            return json_encode($aimagCities->paginate(Request::input('per_page'),['id', 'name']));
        }
        return Inertia::render('Admin/aimag_cities/Index', [
            'filters' => Request::only(["search", ...AimagCity::$searchIn]),
            'datas' => $aimagCities
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','code','name')),
            'host' => config('app.url'),
        ]);
    }


    public function create()
    {
        return Inertia::render('Admin/aimag_cities/Create', ['host' => config('app.url')]);
    }


    public function store()
    {
        AimagCity::create(Request::validate(AimagCity::$rules));
        return Redirect::route('admin.aimag_cities.index')->with('success', 'AimagCity created.');
    }


    public function edit(AimagCity $aimagCity)
    {
        return Inertia::render('Admin/aimag_cities/Edit', [
            'data' =>  $aimagCity,
            'host' => config('app.url'),
        ]);
    }


    public function update(AimagCity $aimagCity)
    {
        $aimagCity->update(Request::validate(AimagCity::$rules));
        return Redirect::route('admin.aimag_cities.index')->with('success', 'AimagCity updated.');
    }


    public function destroy(AimagCity $aimagCity)
    {
        $aimagCity->delete();
        return Redirect::route('admin.aimag_cities.index')->with('success', 'AimagCity deleted.');
    }
}
