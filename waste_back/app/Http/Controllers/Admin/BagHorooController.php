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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $bagHoroos = BagHoroo::filter(Request::all(["search", ...BagHoroo::$searchIn]))->with('soum_district:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($bagHoroos->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/bag_horoos/Index', [
            'filters' => Request::only(["search", ...BagHoroo::$searchIn, 'orderBy', 'dir']),
            'datas' => $bagHoroos
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new BagHoroo.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/bag_horoos/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created BagHoroo in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = BagHoroo::$rules;
        $input =  Request::validate($rule);
        $bagHoroo = BagHoroo::create($input);
        return redirect(Request::header('back') ?? route('admin.bag_horoos.show', $bagHoroo->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param BagHoroo $bagHoroo
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(BagHoroo $bagHoroo)
    {
        $bagHoroo->load('soum_district:id,name');
        return Inertia::render('Admin/bag_horoos/Show', [
            'data' =>  $bagHoroo,
        ]);
    }

    /**
     * Show the form for editing the specified BagHoroo.
     *
     * @param BagHoroo $bagHoroo
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(BagHoroo $bagHoroo)
    {
        $bagHoroo->load('soum_district:id,name');
        return Inertia::render('Admin/bag_horoos/Edit', [
            'data' =>  $bagHoroo,
        ]);
    }

    /**
     * Update the specified BagHoroo in storage.
     *
     * @param BagHoroo $bagHoroo
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(BagHoroo $bagHoroo)
    {
        $rule = BagHoroo::$rules;
        $input =  Request::validate($rule);
        $bagHoroo->update($input);
        
        return redirect(Request::header('back') ?? route('admin.bag_horoos.show', $bagHoroo->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified BagHoroo from storage.
     *
     * @param BagHoroo $bagHoroo
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(BagHoroo $bagHoroo)
    {
        $bagHoroo->delete();
        return redirect(Request::header('back') ?? route('admin.bag_horoos.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
