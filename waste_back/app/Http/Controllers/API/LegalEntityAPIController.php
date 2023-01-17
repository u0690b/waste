<?php

namespace App\Http\Controllers\API;


use App\Models\LegalEntity;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LegalEntityController
 * @package App\Http\Controllers\API
 */

class LegalEntityAPIController extends AppBaseController
{
    /**
     * Display a listing of the LegalEntity.
     * GET|HEAD /legalEntities
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = LegalEntity::filter( $request->all(["search", ...LegalEntity::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } else {
            if (count((array)$request->input('search')) < 5)
                $query->limit(20);
            else
                $query->limit(50);
        }

        $statuses = $query->get()->transform(
            function ($item, $key) {
                return [
                    'name' => $item->name,
                    'id' => $item->register,
                    'industry' => $item->industry,
                ];
            }
        );

        return  $statuses->toJson(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created LegalEntity in storage.
     * POST /legalEntities
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(LegalEntity::$rules);

        /** @var LegalEntity $legalEntity */
        $legalEntity = LegalEntity::create($input);

        return $legalEntity->toJson();
    }

    /**
     * Display the specified LegalEntity.
     * GET|HEAD /legalEntities/{id}
     *
     * @param LegalEntity $legalEntities
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LegalEntity $legalEntity */
        $legalEntity = LegalEntity::find($id);

        if (empty($legalEntity)) {
            return $this->sendError('Legal Entity not found');
        }

        return $legalEntity->toJson();
    }

    /**
     * Update the specified LegalEntity in storage.
     * PUT/PATCH /legalEntities/{id}
     *
     * @param LegalEntity $legalEntities
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(LegalEntity::$rules);
        /** @var LegalEntity $legalEntity */
        $legalEntity = LegalEntity::find($id);

        if (empty($legalEntity)) {
            return $this->sendError('Legal Entity not found');
        }

        $legalEntity->fill($input);
        $legalEntity->save();

        return $legalEntity->toJson();
    }

    /**
     * Remove the specified LegalEntity from storage.
     * DELETE /legalEntities/{id}
     *
     * @param LegalEntity $legalEntities
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LegalEntity $legalEntity */
        $legalEntity = LegalEntity::find($id);

        if (empty($legalEntity)) {
            return $this->sendError('Legal Entity not found');
        }

        $legalEntity->delete();

        return $this->sendSuccess('Legal Entity deleted successfully');
    }
}
