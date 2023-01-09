<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Auth;
use Date;
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
        $input = Request::all(["search", ...Notification::$searchIn]);
        $input['user_id'] = Auth::user()->id;
        $notifications = Notification::filter($input)->with('user:id,name')->orderByDesc('id')->paginate(Request::input('per_page') ?? 35);

        Notification::whereReadAt(null)->update(['read_at' => Date::now()]);
        return Inertia::render('Admin/notifications/Index', [
            'filters' => Request::only(["search", ...Notification::$searchIn]),
            'datas' => $notifications

                ->withQueryString(),
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
