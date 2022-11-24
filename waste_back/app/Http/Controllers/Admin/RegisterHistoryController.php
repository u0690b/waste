<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegisterHistory;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class RegisterHistoryController extends Controller
{
    /**
     * Display a listing of the RegisterHistory.
     *
     * @return Response
     */
    public function index()
    {
        $registerHistories = RegisterHistory::filter(Request::all(["search", ...RegisterHistory::$searchIn]))->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('reason:id,name')->with('register:id,name')->with('soum_district:id,name')->with('status:id,name')->with('user:id,name')->paginate();
        if (Request::has('only')) {
            return json_encode($registerHistories->only('id', 'name'));
        }
        return Inertia::render('Admin/register_histories/Index', [
            'filters' => Request::only(["search", ...RegisterHistory::$searchIn]),
            'datas' => $registerHistories
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','register','register_id','long','lat','description','resolve_desc','reason','reason_id','status','status_id','aimag_city','aimag_city_id','soum_district','soum_district_id','bag_horoo','bag_horoo_id','address','user','user_id')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new RegisterHistory.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/register_histories/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created RegisterHistory in storage.
     *
     * @return Response
     */
    public function store()
    {
        RegisterHistory::create(Request::validate(RegisterHistory::$rules));
        return Redirect::route('admin.register_histories.index')->with('success', 'RegisterHistory created.');
    }

    /**
     * Show the form for editing the specified RegisterHistory.
     *
     * @param RegisterHistory $registerHistory
     *
     * @return Response
     */
    public function edit(RegisterHistory $registerHistory)
    {
        return Inertia::render('Admin/register_histories/Edit', [
            'data' =>  $registerHistory,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified RegisterHistory in storage.
     *
     * @param RegisterHistory $registerHistory
     *
     * @return Response
     */
    public function update(RegisterHistory $registerHistory)
    {
        $registerHistory->update(Request::validate(RegisterHistory::$rules));
        return Redirect::route('admin.register_histories.index')->with('success', 'RegisterHistory updated.');
    }

    /**
     * Remove the specified RegisterHistory from storage.
     *
     * @param RegisterHistory $registerHistory
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(RegisterHistory $registerHistory)
    {
        $registerHistory->delete();
        return Redirect::route('admin.register_histories.index')->with('success', 'RegisterHistory deleted.');
    }
}
