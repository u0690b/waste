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
     * Display a listing of the LegalEntity.
     *
     * @return Response
     */
    public function index()
    {
        $legalEntities = LegalEntity::filter(Request::all(["search", ...LegalEntity::$searchIn]));
        if (Request::has('only')) {
            return json_encode($legalEntities->paginate(Request::input('per_page'),['id', 'name']));
        }
        return Inertia::render('Admin/legal_entities/Index', [
            'filters' => Request::only(["search", ...LegalEntity::$searchIn]),
            'datas' => $legalEntities
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','register','name','industry')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new LegalEntity.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/legal_entities/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created LegalEntity in storage.
     *
     * @return Response
     */
    public function store()
    {
        LegalEntity::create(Request::validate(LegalEntity::$rules));
        return Redirect::route('admin.legal_entities.index')->with('success', 'LegalEntity created.');
    }

    /**
     * Show the form for editing the specified LegalEntity.
     *
     * @param LegalEntity $legalEntity
     *
     * @return Response
     */
    public function edit(LegalEntity $legalEntity)
    {
        return Inertia::render('Admin/legal_entities/Edit', [
            'data' =>  $legalEntity,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified LegalEntity in storage.
     *
     * @param LegalEntity $legalEntity
     *
     * @return Response
     */
    public function update(LegalEntity $legalEntity)
    {
        $legalEntity->update(Request::validate(LegalEntity::$rules));
        return Redirect::route('admin.legal_entities.index')->with('success', 'LegalEntity updated.');
    }

    /**
     * Remove the specified LegalEntity from storage.
     *
     * @param LegalEntity $legalEntity
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(LegalEntity $legalEntity)
    {
        $legalEntity->delete();
        return Redirect::route('admin.legal_entities.index')->with('success', 'LegalEntity deleted.');
    }
}
