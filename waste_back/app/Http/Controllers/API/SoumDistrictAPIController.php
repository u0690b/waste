<?php

namespace App\Http\Controllers\API;


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
        $query = SoumDistrict::filter( $request->all(["search", ...SoumDistrict::$searchIn]))->with('aimag_city:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $soumDistricts = $query->get();

        return $soumDistricts->toJson();
    }

    /**
     * Store a newly created SoumDistrict in storage.
     * POST /soumDistricts
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(SoumDistrict::$rules);

        /** @var SoumDistrict $soumDistrict */
        $soumDistrict = SoumDistrict::create($input);

        return $soumDistrict->toJson();
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

        return $soumDistrict->toJson();
    }

    /**
     * Update the specified SoumDistrict in storage.
     * PUT/PATCH /soumDistricts/{id}
     *
     * @param SoumDistrict $soumDistricts
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(SoumDistrict::$rules);
        /** @var SoumDistrict $soumDistrict */
        $soumDistrict = SoumDistrict::find($id);

        if (empty($soumDistrict)) {
            return $this->sendError('Soum District not found');
        }

        $soumDistrict->fill($input);
        $soumDistrict->save();

        return $soumDistrict->toJson();
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
