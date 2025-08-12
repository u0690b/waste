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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $soumDistricts = SoumDistrict::filter(Request::all(["search", ...SoumDistrict::$searchIn]))->with('aimag_city:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($soumDistricts->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/soum_districts/Index', [
            'filters' => Request::only(["search", ...SoumDistrict::$searchIn, 'orderBy', 'dir']),
            'datas' => $soumDistricts
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new SoumDistrict.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/soum_districts/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created SoumDistrict in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = SoumDistrict::$rules;
        $input =  Request::validate($rule);
        $soumDistrict = SoumDistrict::create($input);
        return redirect(Request::header('back') ?? route('admin.soum_districts.show', $soumDistrict->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param SoumDistrict $soumDistrict
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(SoumDistrict $soumDistrict)
    {
        $soumDistrict->load('aimag_city:id,name');
        return Inertia::render('Admin/soum_districts/Show', [
            'data' =>  $soumDistrict,
        ]);
    }

    /**
     * Show the form for editing the specified SoumDistrict.
     *
     * @param SoumDistrict $soumDistrict
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(SoumDistrict $soumDistrict)
    {
        $soumDistrict->load('aimag_city:id,name');
        return Inertia::render('Admin/soum_districts/Edit', [
            'data' =>  $soumDistrict,
        ]);
    }

    /**
     * Update the specified SoumDistrict in storage.
     *
     * @param SoumDistrict $soumDistrict
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(SoumDistrict $soumDistrict)
    {
        $rule = SoumDistrict::$rules;
        $input =  Request::validate($rule);
        $soumDistrict->update($input);
        
        return redirect(Request::header('back') ?? route('admin.soum_districts.show', $soumDistrict->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified SoumDistrict from storage.
     *
     * @param SoumDistrict $soumDistrict
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(SoumDistrict $soumDistrict)
    {
        $soumDistrict->delete();
        return redirect(Request::header('back') ?? route('admin.soum_districts.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
