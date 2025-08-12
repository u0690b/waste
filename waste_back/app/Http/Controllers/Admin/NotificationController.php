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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {

        $input = Request::all(["search", ...Notification::$searchIn]);
        $input['user_id'] = Auth::user()->id;

        Notification::whereReadAt(null)->update(['read_at' => Date::now()]);

        $notifications = Notification::filter($input)->with('user:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');

        if (Request::has('only')) {
            return json_encode($notifications->cursorPaginate(Request::input('per_page'), ['id', 'name']));
        }

        return Inertia::render('Admin/notifications/Index', [
            'filters' => Request::only(["search", ...Notification::$searchIn, 'orderBy', 'dir']),
            'datas' => $notifications
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/notifications/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Notification::$rules;
        $input = Request::validate($rule);
        $notification = Notification::create($input);
        return redirect(Request::header('back') ?? route('admin.notifications.show', $notification->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Notification $notification
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Notification $notification)
    {
        $notification->load('user:id,name');
        return Inertia::render('Admin/notifications/Show', [
            'data' => $notification,
        ]);
    }

    /**
     * Show the form for editing the specified Notification.
     *
     * @param Notification $notification
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Notification $notification)
    {
        $notification->load('user:id,name');
        return Inertia::render('Admin/notifications/Edit', [
            'data' => $notification,
        ]);
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param Notification $notification
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Notification $notification)
    {
        $rule = Notification::$rules;
        $input = Request::validate($rule);
        $notification->update($input);

        return redirect(Request::header('back') ?? route('admin.notifications.show', $notification->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param Notification $notification
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect(Request::header('back') ?? route('admin.notifications.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
