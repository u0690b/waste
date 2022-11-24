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
     * @return Response
     */
    public function index()
    {
        $statuses = Status::filter(Request::all(["search", ...Status::$searchIn]))->paginate();
        if (Request::has('only')) {
            return json_encode($statuses->only('id', 'name'));
        }
        return Inertia::render('Admin/statuses/Index', [
            'filters' => Request::only(["search", ...Status::$searchIn]),
            'datas' => $statuses
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','name')),
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
        return Inertia::render('Admin/statuses/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Status in storage.
     *
     * @return Response
     */
    public function store()
    {
        Status::create(Request::validate(Status::$rules));
        return Redirect::route('admin.statuses.index')->with('success', 'Status created.');
    }

    /**
     * Show the form for editing the specified Status.
     *
     * @param Status $status
     *
     * @return Response
     */
    public function edit(Status $status)
    {
        return Inertia::render('Admin/statuses/Edit', [
            'data' =>  $status,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified Status in storage.
     *
     * @param Status $status
     *
     * @return Response
     */
    public function update(Status $status)
    {
        $status->update(Request::validate(Status::$rules));
        return Redirect::route('admin.statuses.index')->with('success', 'Status updated.');
    }

    /**
     * Remove the specified Status from storage.
     *
     * @param Status $status
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Status $status)
    {
        $status->delete();
        return Redirect::route('admin.statuses.index')->with('success', 'Status deleted.');
    }
}
