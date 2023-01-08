<?php

namespace App\Http\Controllers\API;


use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Auth;
use Date;
use Response;

/**
 * Class NotificationController
 * @package App\Http\Controllers\API
 */

class NotificationAPIController extends AppBaseController
{
    /**
     * Display a listing of the Notification.
     * GET|HEAD /notifications
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $input = $request->all(["search", ...Notification::$searchIn]);
        $input['user_id'] = Auth::user()->id;
        $query = Notification::filter($input);

        // $notifications = $query->get();
        $pagination = $query->orderByDesc('id')->cursorPaginate(null, ['*'], 'cursor', $request->input('next_cursor'))->toArray();
        $pagination['count'] = $query->whereReadAt(null)->count();
        return $pagination;
    }

    /**
     * Update the specified Notification in storage.
     * PUT/PATCH /notifications/{id}
     *
     * @param Notification $notifications
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        // $input = $request->validate(Notification::$rules);
        /** @var Notification $notification */
        $notification = Notification::find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }
        $input['read_at'] = Date::now();
        $notification->fill($input);
        $notification->save();

        return true;
    }
}
