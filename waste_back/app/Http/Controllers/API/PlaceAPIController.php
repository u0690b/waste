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
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->validate(['date' => 'nullable|date']);
        if (isset($input['date'])) {
            $count =   Place::where('updated_at', '>', $input['date'])->orWhere('created_at', '>', $input['date'])->count();
            if ($count <= 0) {
                return [];
            }
        }
        $query = Place::filter($request->all(["search", ...Place::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $places = $query->get();

        return   $places->toJson(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created Place in storage.
     * POST /places
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(Place::$rules);

        /** @var Place $place */
        $place = Place::create($input);

        return $place;
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

        return $place;
    }

    /**
     * Update the specified Place in storage.
     * PUT/PATCH /places/{id}
     *
     * @param Place $places
     *
     * @return Response
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

        return $place;
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
