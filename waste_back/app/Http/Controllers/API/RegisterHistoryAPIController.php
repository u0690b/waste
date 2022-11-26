<?php

namespace App\Http\Controllers\API;


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
        $query = RegisterHistory::filter( $request->all(["search", ...RegisterHistory::$searchIn]))->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('reason:id,name')->with('register:id,name')->with('soum_district:id,name')->with('status:id,name')->with('user:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $registerHistories = $query->get();

        return $registerHistories->toJson();
    }

    /**
     * Store a newly created RegisterHistory in storage.
     * POST /registerHistories
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(RegisterHistory::$rules);

        /** @var RegisterHistory $registerHistory */
        $registerHistory = RegisterHistory::create($input);

        return $registerHistory->toJson();
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

        return $registerHistory->toJson();
    }

    /**
     * Update the specified RegisterHistory in storage.
     * PUT/PATCH /registerHistories/{id}
     *
     * @param RegisterHistory $registerHistories
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(RegisterHistory::$rules);
        /** @var RegisterHistory $registerHistory */
        $registerHistory = RegisterHistory::find($id);

        if (empty($registerHistory)) {
            return $this->sendError('Register History not found');
        }

        $registerHistory->fill($input);
        $registerHistory->save();

        return $registerHistory->toJson();
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
