<?php

namespace App\Http\Controllers\API;


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
        $input = $request->validate(['date' => 'nullable|date']);
        if (isset($input['date'])) {
            $count =   AimagCity::where('updated_at', '>', $input['date'])->orWhere('created_at', '>', $input['date'])->count();
            if ($count <= 0) {
                return [];
            }
        }
        $query = AimagCity::filter($request->all(["search", ...AimagCity::$searchIn]));


        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $aimagCities = $query->get();

        return  $aimagCities->toJson(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created AimagCity in storage.
     * POST /aimagCities
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(AimagCity::$rules);

        /** @var AimagCity $aimagCity */
        $aimagCity = AimagCity::create($input);

        return $aimagCity;
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

        return $aimagCity;
    }

    /**
     * Update the specified AimagCity in storage.
     * PUT/PATCH /aimagCities/{id}
     *
     * @param AimagCity $aimagCities
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(AimagCity::$rules);
        /** @var AimagCity $aimagCity */
        $aimagCity = AimagCity::find($id);

        if (empty($aimagCity)) {
            return $this->sendError('Aimag City not found');
        }

        $aimagCity->fill($input);
        $aimagCity->save();

        return $aimagCity;
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
