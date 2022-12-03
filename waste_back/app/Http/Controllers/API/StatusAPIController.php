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
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->validate(['date' => 'nullable|date']);
        if (isset($input['date'])) {
            $count =   Status::where('updated_at', '>', $input['date'])->orWhere('created_at', '>', $input['date'])->count();
            if ($count <= 0) {
                return [];
            }
        }
        $query = Status::filter($request->all(["search", ...Status::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $statuses = $query->get();

        return $statuses;
    }

    /**
     * Store a newly created Status in storage.
     * POST /statuses
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(Status::$rules);

        /** @var Status $status */
        $status = Status::create($input);

        return $status;
    }

    /**
     * Display the specified Status.
     * GET|HEAD /statuses/{id}
     *
     * @param Status $statuses
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Status $status */
        $status = Status::find($id);

        if (empty($status)) {
            return $this->sendError('Status not found');
        }

        return $status;
    }

    /**
     * Update the specified Status in storage.
     * PUT/PATCH /statuses/{id}
     *
     * @param Status $statuses
     *
     * @return Response
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

        return $status;
    }

    /**
     * Remove the specified Status from storage.
     * DELETE /statuses/{id}
     *
     * @param Status $statuses
     *
     * @throws \Exception
     *
     * @return Response
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
