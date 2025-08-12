<?php

namespace App\Http\Controllers\API;


use App\Models\Resolve;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ResolveController
 * @package App\Http\Controllers\API
 */

class ResolveAPIController extends AppBaseController
{
    /**
     * Display a listing of the Resolve.
     * GET|HEAD /resolves
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Resolve::filter( $request->all(["search", ...Resolve::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $resolves = $query->get();

        return $resolves->toJson();
    }

    /**
     * Store a newly created Resolve in storage.
     * POST /resolves
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Resolve::$rules);

        /** @var Resolve $resolve */
        $resolve = Resolve::create($input);

        return $resolve->toJson();
    }

    /**
     * Display the specified Resolve.
     * GET|HEAD /resolves/{id}
     *
     * @param Resolve $resolves
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Resolve $resolve */
        $resolve = Resolve::find($id);

        if (empty($resolve)) {
            return $this->sendError('Resolve not found');
        }

        return $resolve->toJson();
    }

    /**
     * Update the specified Resolve in storage.
     * PUT/PATCH /resolves/{id}
     *
     * @param Resolve $resolves
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Resolve::$rules);
        /** @var Resolve $resolve */
        $resolve = Resolve::find($id);

        if (empty($resolve)) {
            return $this->sendError('Resolve not found');
        }

        $resolve->fill($input);
        $resolve->save();

        return $resolve->toJson();
    }

    /**
     * Remove the specified Resolve from storage.
     * DELETE /resolves/{id}
     *
     * @param Resolve $resolves
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Resolve $resolve */
        $resolve = Resolve::find($id);

        if (empty($resolve)) {
            return $this->sendError('Resolve not found');
        }

        $resolve->delete();

        return $this->sendSuccess('Resolve deleted successfully');
    }
}
