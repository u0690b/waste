<?php

namespace App\Http\Controllers\API;


use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PlaceController
 * @package App\Http\Controllers\API
 */

class PlaceAPIController extends AppBaseController
{
    /**
     * Display a listing of the Place.
     * GET|HEAD /places
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Place::filter( $request->all(["search", ...Place::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $places = $query->get();

        return $places->toJson();
    }

    /**
     * Store a newly created Place in storage.
     * POST /places
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Place::$rules);

        /** @var Place $place */
        $place = Place::create($input);

        return $place->toJson();
    }

    /**
     * Display the specified Place.
     * GET|HEAD /places/{id}
     *
     * @param Place $places
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Place $place */
        $place = Place::find($id);

        if (empty($place)) {
            return $this->sendError('Place not found');
        }

        return $place->toJson();
    }

    /**
     * Update the specified Place in storage.
     * PUT/PATCH /places/{id}
     *
     * @param Place $places
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Place::$rules);
        /** @var Place $place */
        $place = Place::find($id);

        if (empty($place)) {
            return $this->sendError('Place not found');
        }

        $place->fill($input);
        $place->save();

        return $place->toJson();
    }

    /**
     * Remove the specified Place from storage.
     * DELETE /places/{id}
     *
     * @param Place $places
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Place $place */
        $place = Place::find($id);

        if (empty($place)) {
            return $this->sendError('Place not found');
        }

        $place->delete();

        return $this->sendSuccess('Place deleted successfully');
    }
}
