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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $resolfs = Resolve::filter(Request::all(["search", ...Resolve::$searchIn]))
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');

        if (Request::has('only')) {
            return json_encode($resolfs->cursorPaginate(Request::input('per_page'), ['id', 'name']));
        }

        return Inertia::render('Admin/resolves/Index', [
            'filters' => Request::only(["search", ...Resolve::$searchIn, 'orderBy', 'dir']),
            'datas' => $resolfs
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Resolve.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/resolves/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Resolve in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Resolve::$rules;
        $input = Request::validate($rule);
        $resolf = Resolve::create($input);
        return redirect(Request::header('back') ?? route('admin.resolves.show', $resolf->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Resolve $resolf
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Resolve $resolf)
    {
        $resolf;
        return Inertia::render('Admin/resolves/Show', [
            'data' => $resolf,
        ]);
    }

    /**
     * Show the form for editing the specified Resolve.
     *
     * @param Resolve $resolf
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Resolve $resolf)
    {
        $resolf;
        return Inertia::render('Admin/resolves/Edit', [
            'data' => $resolf,
        ]);
    }

    /**
     * Update the specified Resolve in storage.
     *
     * @param Resolve $resolf
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Resolve $resolf)
    {
        $rule = Resolve::$rules;
        $input = Request::validate($rule);
        $resolf->update($input);

        return redirect(Request::header('back') ?? route('admin.resolves.show', $resolf->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Resolve from storage.
     *
     * @param Resolve $resolf
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Resolve $resolf)
    {
        $resolf->delete();
        return redirect(Request::header('back') ?? route('admin.resolves.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
