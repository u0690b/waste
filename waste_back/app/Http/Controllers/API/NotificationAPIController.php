<?php

namespace App\Http\Controllers\API;


use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
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
        $query = Notification::filter( $request->all(["search", ...Notification::$searchIn]))->with('user:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $notifications = $query->get();

        return $notifications->toJson();
    }

    /**
     * Store a newly created Notification in storage.
     * POST /notifications
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(Notification::$rules);

        /** @var Notification $notification */
        $notification = Notification::create($input);

        return $notification->toJson();
    }

    /**
     * Display the specified Notification.
     * GET|HEAD /notifications/{id}
     *
     * @param Notification $notifications
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Notification $notification */
        $notification = Notification::find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        return $notification->toJson();
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
        $input = $request->validate(Notification::$rules);
        /** @var Notification $notification */
        $notification = Notification::find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification->fill($input);
        $notification->save();

        return $notification->toJson();
    }

    /**
     * Remove the specified Notification from storage.
     * DELETE /notifications/{id}
     *
     * @param Notification $notifications
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Notification $notification */
        $notification = Notification::find($id);

        if (empty($notification)) {
            return $this->sendError('Notification not found');
        }

        $notification->delete();

        return $this->sendSuccess('Notification deleted successfully');
    }
}
