<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReasonAPIRequest;
use App\Http\Requests\API\UpdateReasonAPIRequest;
use App\Models\Reason;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ReasonController
 * @package App\Http\Controllers\API
 */

class ReasonAPIController extends AppBaseController
{
    /**
     * Display a listing of the Reason.
     * GET|HEAD /reasons
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Reason::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $reasons = $query->get();

        return $this->sendResponse($reasons->toArray(), 'Reasons retrieved successfully');
    }

    /**
     * Store a newly created Reason in storage.
     * POST /reasons
     *
     * @return Response
     */
    public function store(CreateReasonAPIRequest $request)
    {
        $input = $request->all();

        /** @var Reason $reason */
        $reason = Reason::create($input);

        return $this->sendResponse($reason->toArray(), 'Reason saved successfully');
    }

    /**
     * Display the specified Reason.
     * GET|HEAD /reasons/{id}
     *
     * @param Reason $reasons
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Reason $reason */
        $reason = Reason::find($id);

        if (empty($reason)) {
            return $this->sendError('Reason not found');
        }

        return $this->sendResponse($reason->toArray(), 'Reason retrieved successfully');
    }

    /**
     * Update the specified Reason in storage.
     * PUT/PATCH /reasons/{id}
     *
     * @param Reason $reasons
     *
     * @return Response
     */
    public function update($id, UpdateReasonAPIRequest $request)
    {
        /** @var Reason $reason */
        $reason = Reason::find($id);

        if (empty($reason)) {
            return $this->sendError('Reason not found');
        }

        $reason->fill($request->all());
        $reason->save();

        return $this->sendResponse($reason->toArray(), 'Reason updated successfully');
    }

    /**
     * Remove the specified Reason from storage.
     * DELETE /reasons/{id}
     *
     * @param Reason $reasons
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Reason $reason */
        $reason = Reason::find($id);

        if (empty($reason)) {
            return $this->sendError('Reason not found');
        }

        $reason->delete();

        return $this->sendSuccess('Reason deleted successfully');
    }
}
