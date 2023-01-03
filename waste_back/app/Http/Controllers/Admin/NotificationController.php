<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the Notification.
     *
     * @return Response
     */
    public function index()
    {
        $notifications = Notification::filter(Request::all(["search", ...Notification::$searchIn]))->with('user:id,name');
        if (Request::has('only')) {
            return json_encode($notifications->paginate(Request::input('per_page'),['id', 'name']));
        }
        return Inertia::render('Admin/notifications/Index', [
            'filters' => Request::only(["search", ...Notification::$searchIn]),
            'datas' => $notifications
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','user','user_id','type','title','content','read_at')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/notifications/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @return Response
     */
    public function store()
    {
        Notification::create(Request::validate(Notification::$rules));
        return Redirect::route('admin.notifications.index')->with('success', 'Notification created.');
    }

    /**
     * Show the form for editing the specified Notification.
     *
     * @param Notification $notification
     *
     * @return Response
     */
    public function edit(Notification $notification)
    {
        return Inertia::render('Admin/notifications/Edit', [
            'data' =>  $notification,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param Notification $notification
     *
     * @return Response
     */
    public function update(Notification $notification)
    {
        $notification->update(Request::validate(Notification::$rules));
        return Redirect::route('admin.notifications.index')->with('success', 'Notification updated.');
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param Notification $notification
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return Redirect::route('admin.notifications.index')->with('success', 'Notification deleted.');
    }
}
