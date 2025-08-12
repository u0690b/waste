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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $legalEntities = LegalEntity::filter(Request::all(["search", ...LegalEntity::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($legalEntities->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/legal_entities/Index', [
            'filters' => Request::only(["search", ...LegalEntity::$searchIn, 'orderBy', 'dir']),
            'datas' => $legalEntities
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new LegalEntity.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/legal_entities/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created LegalEntity in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = LegalEntity::$rules;
        $input =  Request::validate($rule);
        $legalEntity = LegalEntity::create($input);
        return redirect(Request::header('back') ?? route('admin.legal_entities.show', $legalEntity->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param LegalEntity $legalEntity
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(LegalEntity $legalEntity)
    {
        $legalEntity;
        return Inertia::render('Admin/legal_entities/Show', [
            'data' =>  $legalEntity,
        ]);
    }

    /**
     * Show the form for editing the specified LegalEntity.
     *
     * @param LegalEntity $legalEntity
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(LegalEntity $legalEntity)
    {
        $legalEntity;
        return Inertia::render('Admin/legal_entities/Edit', [
            'data' =>  $legalEntity,
        ]);
    }

    /**
     * Update the specified LegalEntity in storage.
     *
     * @param LegalEntity $legalEntity
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(LegalEntity $legalEntity)
    {
        $rule = LegalEntity::$rules;
        $input =  Request::validate($rule);
        $legalEntity->update($input);
        
        return redirect(Request::header('back') ?? route('admin.legal_entities.show', $legalEntity->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified LegalEntity from storage.
     *
     * @param LegalEntity $legalEntity
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(LegalEntity $legalEntity)
    {
        $legalEntity->delete();
        return redirect(Request::header('back') ?? route('admin.legal_entities.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
