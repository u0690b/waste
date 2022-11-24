<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRegisterHistoryAPIRequest;
use App\Http\Requests\API\UpdateRegisterHistoryAPIRequest;
use App\Models\RegisterHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class RegisterHistoryController
 * @package App\Http\Controllers\API
 */

class RegisterHistoryAPIController extends AppBaseController
{
    /**
     * Display a listing of the RegisterHistory.
     * GET|HEAD /registerHistories
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = RegisterHistory::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $registerHistories = $query->get();

        return $this->sendResponse($registerHistories->toArray(), 'Register Histories retrieved successfully');
    }

    /**
     * Store a newly created RegisterHistory in storage.
     * POST /registerHistories
     *
     * @return Response
     */
    public function store(CreateRegisterHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var RegisterHistory $registerHistory */
        $registerHistory = RegisterHistory::create($input);

        return $this->sendResponse($registerHistory->toArray(), 'Register History saved successfully');
    }

    /**
     * Display the specified RegisterHistory.
     * GET|HEAD /registerHistories/{id}
     *
     * @param RegisterHistory $registerHistories
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RegisterHistory $registerHistory */
        $registerHistory = RegisterHistory::find($id);

        if (empty($registerHistory)) {
            return $this->sendError('Register History not found');
        }

        return $this->sendResponse($registerHistory->toArray(), 'Register History retrieved successfully');
    }

    /**
     * Update the specified RegisterHistory in storage.
     * PUT/PATCH /registerHistories/{id}
     *
     * @param RegisterHistory $registerHistories
     *
     * @return Response
     */
    public function update($id, UpdateRegisterHistoryAPIRequest $request)
    {
        /** @var RegisterHistory $registerHistory */
        $registerHistory = RegisterHistory::find($id);

        if (empty($registerHistory)) {
            return $this->sendError('Register History not found');
        }

        $registerHistory->fill($request->all());
        $registerHistory->save();

        return $this->sendResponse($registerHistory->toArray(), 'RegisterHistory updated successfully');
    }

    /**
     * Remove the specified RegisterHistory from storage.
     * DELETE /registerHistories/{id}
     *
     * @param RegisterHistory $registerHistories
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RegisterHistory $registerHistory */
        $registerHistory = RegisterHistory::find($id);

        if (empty($registerHistory)) {
            return $this->sendError('Register History not found');
        }

        $registerHistory->delete();

        return $this->sendSuccess('Register History deleted successfully');
    }
}
