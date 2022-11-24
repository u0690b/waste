<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class ReasonController extends Controller
{
    /**
     * Display a listing of the Reason.
     *
     * @return Response
     */
    public function index()
    {
        $reasons = Reason::filter(Request::all(["search", ...Reason::$searchIn]))->with('place:id,name')->paginate();
        if (Request::has('only')) {
            return json_encode($reasons->only('id', 'name'));
        }
        return Inertia::render('Admin/reasons/Index', [
            'filters' => Request::only(["search", ...Reason::$searchIn]),
            'datas' => $reasons
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','name','place','place_id')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Reason.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/reasons/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Reason in storage.
     *
     * @return Response
     */
    public function store()
    {
        Reason::create(Request::validate(Reason::$rules));
        return Redirect::route('admin.reasons.index')->with('success', 'Reason created.');
    }

    /**
     * Show the form for editing the specified Reason.
     *
     * @param Reason $reason
     *
     * @return Response
     */
    public function edit(Reason $reason)
    {
        return Inertia::render('Admin/reasons/Edit', [
            'data' =>  $reason,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified Reason in storage.
     *
     * @param Reason $reason
     *
     * @return Response
     */
    public function update(Reason $reason)
    {
        $reason->update(Request::validate(Reason::$rules));
        return Redirect::route('admin.reasons.index')->with('success', 'Reason updated.');
    }

    /**
     * Remove the specified Reason from storage.
     *
     * @param Reason $reason
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Reason $reason)
    {
        $reason->delete();
        return Redirect::route('admin.reasons.index')->with('success', 'Reason deleted.');
    }
}
