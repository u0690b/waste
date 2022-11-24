<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAimagCityAPIRequest;
use App\Http\Requests\API\UpdateAimagCityAPIRequest;
use App\Models\AimagCity;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AimagCityController
 * @package App\Http\Controllers\API
 */

class AimagCityAPIController extends AppBaseController
{
    /**
     * Display a listing of the AimagCity.
     * GET|HEAD /aimagCities
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = AimagCity::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $aimagCities = $query->get();

        return $this->sendResponse($aimagCities->toArray(), 'Aimag Cities retrieved successfully');
    }

    /**
     * Store a newly created AimagCity in storage.
     * POST /aimagCities
     *
     * @return Response
     */
    public function store(CreateAimagCityAPIRequest $request)
    {
        $input = $request->all();

        /** @var AimagCity $aimagCity */
        $aimagCity = AimagCity::create($input);

        return $this->sendResponse($aimagCity->toArray(), 'Aimag City saved successfully');
    }

    /**
     * Display the specified AimagCity.
     * GET|HEAD /aimagCities/{id}
     *
     * @param AimagCity $aimagCities
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AimagCity $aimagCity */
        $aimagCity = AimagCity::find($id);

        if (empty($aimagCity)) {
            return $this->sendError('Aimag City not found');
        }

        return $this->sendResponse($aimagCity->toArray(), 'Aimag City retrieved successfully');
    }

    /**
     * Update the specified AimagCity in storage.
     * PUT/PATCH /aimagCities/{id}
     *
     * @param AimagCity $aimagCities
     *
     * @return Response
     */
    public function update($id, UpdateAimagCityAPIRequest $request)
    {
        /** @var AimagCity $aimagCity */
        $aimagCity = AimagCity::find($id);

        if (empty($aimagCity)) {
            return $this->sendError('Aimag City not found');
        }

        $aimagCity->fill($request->all());
        $aimagCity->save();

        return $this->sendResponse($aimagCity->toArray(), 'AimagCity updated successfully');
    }

    /**
     * Remove the specified AimagCity from storage.
     * DELETE /aimagCities/{id}
     *
     * @param AimagCity $aimagCities
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AimagCity $aimagCity */
        $aimagCity = AimagCity::find($id);

        if (empty($aimagCity)) {
            return $this->sendError('Aimag City not found');
        }

        $aimagCity->delete();

        return $this->sendSuccess('Aimag City deleted successfully');
    }
}
