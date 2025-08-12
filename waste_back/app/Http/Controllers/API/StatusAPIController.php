<?php

namespace App\Http\Controllers\API;


use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class StatusController
 * @package App\Http\Controllers\API
 */

class StatusAPIController extends AppBaseController
{
    /**
     * Display a listing of the Status.
     * GET|HEAD /statuses
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Status::filter( $request->all(["search", ...Status::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $statuses = $query->get();

        return $statuses->toJson();
    }

    /**
     * Store a newly created Status in storage.
     * POST /statuses
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Status::$rules);

        /** @var Status $status */
        $status = Status::create($input);

        return $status->toJson();
    }

    /**
     * Display the specified Status.
     * GET|HEAD /statuses/{id}
     *
     * @param Status $statuses
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Status $status */
        $status = Status::find($id);

        if (empty($status)) {
            return $this->sendError('Status not found');
        }

        return $status->toJson();
    }

    /**
     * Update the specified Status in storage.
     * PUT/PATCH /statuses/{id}
     *
     * @param Status $statuses
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Status::$rules);
        /** @var Status $status */
        $status = Status::find($id);

        if (empty($status)) {
            return $this->sendError('Status not found');
        }

        $status->fill($input);
        $status->save();

        return $status->toJson();
    }

    /**
     * Remove the specified Status from storage.
     * DELETE /statuses/{id}
     *
     * @param Status $statuses
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Status $status */
        $status = Status::find($id);

        if (empty($status)) {
            return $this->sendError('Status not found');
        }

        $status->delete();

        return $this->sendSuccess('Status deleted successfully');
    }
}
