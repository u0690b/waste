<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalEntity;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class LegalEntityController extends Controller
{
    /**
     * Display a listing of the Status.
     *
     * @return Response
     */
    public function index()
    {
        $entities = LegalEntity::filter(Request::all(["search", ...LegalEntity::$searchIn]));
        if (Request::has('only')) {
            return json_encode($entities->paginate(Request::input('per_page'),['register', 'name']));
        }
        return Inertia::render('Admin/entities/Index', [
            'filters' => Request::only(["search", ...LegalEntity::$searchIn]),
            'datas' => $entities
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('register','name')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Status.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/entities/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Status in storage.
     *
     * @return Response
     */
    public function store()
    {
        LegalEntity::create(Request::validate(LegalEntity::$rules));
        return Redirect::route('admin.entities.index')->with('success', 'LegalEntity created.');
    }

    /**
     * Show the form for editing the specified Status.
     *
     * @param LegalEntity $legal
     *
     * @return Response
     */
    public function edit(LegalEntity $legal)
    {
        return Inertia::render('Admin/entities/Edit', [
            'data' =>  $legal,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified Status in storage.
     *
     * @param LegalEntity $legal
     *
     * @return Response
     */
    public function update(LegalEntity $legal)
    {
        $status->update(Request::validate(LegalEntity::$rules));
        return Redirect::route('admin.entities.index')->with('success', 'LegalEntity updated.');
    }

    /**
     * Remove the specified Status from storage.
     *
     * @param LegalEntity $legal
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(LegalEntity $legal)
    {
        $legal->delete();
        return Redirect::route('admin.legal.index')->with('success', 'LegalEntity deleted.');
    }
}