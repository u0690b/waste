<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSoumDistrictAPIRequest;
use App\Http\Requests\API\UpdateSoumDistrictAPIRequest;
use App\Models\SoumDistrict;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SoumDistrictController
 * @package App\Http\Controllers\API
 */

class SoumDistrictAPIController extends AppBaseController
{
    /**
     * Display a listing of the SoumDistrict.
     * GET|HEAD /soumDistricts
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = SoumDistrict::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $soumDistricts = $query->get();

        return $this->sendResponse($soumDistricts->toArray(), 'Soum Districts retrieved successfully');
    }

    /**
     * Store a newly created SoumDistrict in storage.
     * POST /soumDistricts
     *
     * @return Response
     */
    public function store(CreateSoumDistrictAPIRequest $request)
    {
        $input = $request->all();

        /** @var SoumDistrict $soumDistrict */
        $soumDistrict = SoumDistrict::create($input);

        return $this->sendResponse($soumDistrict->toArray(), 'Soum District saved successfully');
    }

    /**
     * Display the specified SoumDistrict.
     * GET|HEAD /soumDistricts/{id}
     *
     * @param SoumDistrict $soumDistricts
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SoumDistrict $soumDistrict */
        $soumDistrict = SoumDistrict::find($id);

        if (empty($soumDistrict)) {
            return $this->sendError('Soum District not found');
        }

        return $this->sendResponse($soumDistrict->toArray(), 'Soum District retrieved successfully');
    }

    /**
     * Update the specified SoumDistrict in storage.
     * PUT/PATCH /soumDistricts/{id}
     *
     * @param SoumDistrict $soumDistricts
     *
     * @return Response
     */
    public function update($id, UpdateSoumDistrictAPIRequest $request)
    {
        /** @var SoumDistrict $soumDistrict */
        $soumDistrict = SoumDistrict::find($id);

        if (empty($soumDistrict)) {
            return $this->sendError('Soum District not found');
        }

        $soumDistrict->fill($request->all());
        $soumDistrict->save();

        return $this->sendResponse($soumDistrict->toArray(), 'SoumDistrict updated successfully');
    }

    /**
     * Remove the specified SoumDistrict from storage.
     * DELETE /soumDistricts/{id}
     *
     * @param SoumDistrict $soumDistricts
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SoumDistrict $soumDistrict */
        $soumDistrict = SoumDistrict::find($id);

        if (empty($soumDistrict)) {
            return $this->sendError('Soum District not found');
        }

        $soumDistrict->delete();

        return $this->sendSuccess('Soum District deleted successfully');
    }
}
