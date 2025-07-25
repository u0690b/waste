<?php

namespace App\Http\Controllers\API;


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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Reason::filter( $request->all(["search", ...Reason::$searchIn]))->with('place:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $reasons = $query->get();

        return $reasons->toJson();
    }

    /**
     * Store a newly created Reason in storage.
     * POST /reasons
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Reason::$rules);

        /** @var Reason $reason */
        $reason = Reason::create($input);

        return $reason->toJson();
    }

    /**
     * Display the specified Reason.
     * GET|HEAD /reasons/{id}
     *
     * @param Reason $reasons
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Reason $reason */
        $reason = Reason::find($id);

        if (empty($reason)) {
            return $this->sendError('Reason not found');
        }

        return $reason->toJson();
    }

    /**
     * Update the specified Reason in storage.
     * PUT/PATCH /reasons/{id}
     *
     * @param Reason $reasons
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Reason::$rules);
        /** @var Reason $reason */
        $reason = Reason::find($id);

        if (empty($reason)) {
            return $this->sendError('Reason not found');
        }

        $reason->fill($input);
        $reason->save();

        return $reason->toJson();
    }

    /**
     * Remove the specified Reason from storage.
     * DELETE /reasons/{id}
     *
     * @param Reason $reasons
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
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
