<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePlaceAPIRequest;
use App\Http\Requests\API\UpdatePlaceAPIRequest;
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
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Place::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $places = $query->get();

        return $this->sendResponse($places->toArray(), 'Places retrieved successfully');
    }

    /**
     * Store a newly created Place in storage.
     * POST /places
     *
     * @return Response
     */
    public function store(CreatePlaceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Place $place */
        $place = Place::create($input);

        return $this->sendResponse($place->toArray(), 'Place saved successfully');
    }

    /**
     * Display the specified Place.
     * GET|HEAD /places/{id}
     *
     * @param Place $places
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Place $place */
        $place = Place::find($id);

        if (empty($place)) {
            return $this->sendError('Place not found');
        }

        return $this->sendResponse($place->toArray(), 'Place retrieved successfully');
    }

    /**
     * Update the specified Place in storage.
     * PUT/PATCH /places/{id}
     *
     * @param Place $places
     *
     * @return Response
     */
    public function update($id, UpdatePlaceAPIRequest $request)
    {
        /** @var Place $place */
        $place = Place::find($id);

        if (empty($place)) {
            return $this->sendError('Place not found');
        }

        $place->fill($request->all());
        $place->save();

        return $this->sendResponse($place->toArray(), 'Place updated successfully');
    }

    /**
     * Remove the specified Place from storage.
     * DELETE /places/{id}
     *
     * @param Place $places
     *
     * @throws \Exception
     *
     * @return Response
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
