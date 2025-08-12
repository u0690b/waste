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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $industries = Industry::filter(Request::all(["search", ...Industry::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($industries->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/industries/Index', [
            'filters' => Request::only(["search", ...Industry::$searchIn, 'orderBy', 'dir']),
            'datas' => $industries
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Industry.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/industries/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Industry in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Industry::$rules;
        $input =  Request::validate($rule);
        $industry = Industry::create($input);
        return redirect(Request::header('back') ?? route('admin.industries.show', $industry->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Industry $industry
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Industry $industry)
    {
        $industry;
        return Inertia::render('Admin/industries/Show', [
            'data' =>  $industry,
        ]);
    }

    /**
     * Show the form for editing the specified Industry.
     *
     * @param Industry $industry
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Industry $industry)
    {
        $industry;
        return Inertia::render('Admin/industries/Edit', [
            'data' =>  $industry,
        ]);
    }

    /**
     * Update the specified Industry in storage.
     *
     * @param Industry $industry
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Industry $industry)
    {
        $rule = Industry::$rules;
        $input =  Request::validate($rule);
        $industry->update($input);
        
        return redirect(Request::header('back') ?? route('admin.industries.show', $industry->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Industry from storage.
     *
     * @param Industry $industry
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Industry $industry)
    {
        $industry->delete();
        return redirect(Request::header('back') ?? route('admin.industries.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
