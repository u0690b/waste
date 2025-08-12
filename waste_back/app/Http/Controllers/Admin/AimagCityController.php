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
    /**
     * Display a listing of the AimagCity.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $aimagCities = AimagCity::filter(Request::all(["search", ...AimagCity::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($aimagCities->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/aimag_cities/Index', [
            'filters' => Request::only(["search", ...AimagCity::$searchIn, 'orderBy', 'dir']),
            'datas' => $aimagCities
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new AimagCity.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/aimag_cities/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created AimagCity in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = AimagCity::$rules;
        $input =  Request::validate($rule);
        $aimagCity = AimagCity::create($input);
        return redirect(Request::header('back') ?? route('admin.aimag_cities.show', $aimagCity->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param AimagCity $aimagCity
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(AimagCity $aimagCity)
    {
        $aimagCity;
        return Inertia::render('Admin/aimag_cities/Show', [
            'data' =>  $aimagCity,
        ]);
    }

    /**
     * Show the form for editing the specified AimagCity.
     *
     * @param AimagCity $aimagCity
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(AimagCity $aimagCity)
    {
        $aimagCity;
        return Inertia::render('Admin/aimag_cities/Edit', [
            'data' =>  $aimagCity,
        ]);
    }

    /**
     * Update the specified AimagCity in storage.
     *
     * @param AimagCity $aimagCity
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(AimagCity $aimagCity)
    {
        $rule = AimagCity::$rules;
        $input =  Request::validate($rule);
        $aimagCity->update($input);
        
        return redirect(Request::header('back') ?? route('admin.aimag_cities.show', $aimagCity->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified AimagCity from storage.
     *
     * @param AimagCity $aimagCity
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(AimagCity $aimagCity)
    {
        $aimagCity->delete();
        return redirect(Request::header('back') ?? route('admin.aimag_cities.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
