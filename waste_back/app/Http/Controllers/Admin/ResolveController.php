<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resolve;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class ResolveController extends Controller
{
    /**
     * Display a listing of the Resolve.
     *
     * @return Response
     */
    public function index()
    {
        $resolves = Resolve::filter(Request::all(["search", ...Resolve::$searchIn]));
        if (Request::has('only')) {
            return json_encode($resolves->paginate(Request::input('per_page'),['id', 'name']));
        }
        return Inertia::render('Admin/resolves/Index', [
            'filters' => Request::only(["search", ...Resolve::$searchIn]),
            'datas' => $resolves
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','name')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Resolve.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/resolves/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Resolve in storage.
     *
     * @return Response
     */
    public function store()
    {
        Resolve::create(Request::validate(Resolve::$rules));
        return Redirect::route('admin.resolves.index')->with('success', 'Resolve created.');
    }

    /**
     * Show the form for editing the specified Resolve.
     *
     * @param Resolve $resolve
     *
     * @return Response
     */
    public function edit(Resolve $resolve)
    {
        return Inertia::render('Admin/resolves/Edit', [
            'data' =>  $resolve,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified Resolve in storage.
     *
     * @param Resolve $resolve
     *
     * @return Response
     */
    public function update(Resolve $resolve)
    {
        $resolve->update(Request::validate(Resolve::$rules));
        return Redirect::route('admin.resolves.index')->with('success', 'Resolve updated.');
    }

    /**
     * Remove the specified Resolve from storage.
     *
     * @param Resolve $resolve
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Resolve $resolve)
    {
        $resolve->delete();
        return Redirect::route('admin.resolves.index')->with('success', 'Resolve deleted.');
    }
}
