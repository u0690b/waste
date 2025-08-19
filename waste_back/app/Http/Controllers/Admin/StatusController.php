<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class StatusController extends Controller
{
    /**
     * Display a listing of the Status.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $statuses = Status::filter(Request::all(["search", ...Status::$searchIn]))->where('id', '!=', 1)
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');

        if (Request::has('only')) {
            return json_encode($statuses->cursorPaginate(Request::input('per_page'), ['id', 'name']));
        }

        return Inertia::render('Admin/statuses/Index', [
            'filters' => Request::only(["search", ...Status::$searchIn, 'orderBy', 'dir']),
            'datas' => $statuses
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Status.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/statuses/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Status in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Status::$rules;
        $input = Request::validate($rule);
        $status = Status::create($input);
        return redirect(Request::header('back') ?? route('admin.statuses.show', $status->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Status $status
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Status $status)
    {
        $status;
        return Inertia::render('Admin/statuses/Show', [
            'data' => $status,
        ]);
    }

    /**
     * Show the form for editing the specified Status.
     *
     * @param Status $status
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Status $status)
    {
        $status;
        return Inertia::render('Admin/statuses/Edit', [
            'data' => $status,
        ]);
    }

    /**
     * Update the specified Status in storage.
     *
     * @param Status $status
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Status $status)
    {
        $rule = Status::$rules;
        $input = Request::validate($rule);
        $status->update($input);

        return redirect(Request::header('back') ?? route('admin.statuses.show', $status->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Status from storage.
     *
     * @param Status $status
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Status $status)
    {
        $status->delete();
        return redirect(Request::header('back') ?? route('admin.statuses.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
