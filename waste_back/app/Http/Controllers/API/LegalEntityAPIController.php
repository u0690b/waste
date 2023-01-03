<?php

namespace App\Http\Controllers\API;


use App\Models\LegalEntity;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class StatusController
 * @package App\Http\Controllers\API
 */

class LegalEntityAPIController extends AppBaseController
{
    /**
     * Display a listing of the LegalEntity.
     * GET|HEAD /entities
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $input = $request->validate(['date' => 'nullable|date']);
        // if (isset($input['date'])) {
        //     $count =   LegalEntity::where('updated_at', '>', $input['date'])->orWhere('created_at', '>', $input['date'])->count();
        //     if ($count <= 0) {
        //         return [];
        //     }
        // }
        $query = LegalEntity::filter($request->all(["search", ...LegalEntity::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } else {
            $query->limit(10);
        }

        $statuses = $query->get(['register', 'name'])->transform(
            function ($item, $key) {
                return [
                    'name' => $item->name,
                    'id' => $item->register,
                ];
            }
        );

        return  $statuses->toJson(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created Status in storage.
     * POST /statuses
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(LegalEntity::$rules);

        /** @var LegalEntity $entities */
        $entities = LegalEntity::create($input);

        return $entities;
    }

    /**
     * Display the specified LegalEntity.
     * GET|HEAD /entities/{id}
     *
     * @param LegalEntity $entities
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var LegalEntity $entities */
        $entities = LegalEntity::find($id);

        if (empty($entities)) {
            return $this->sendError('Entity not found');
        }

        return $entities;
    }

    /**
     * Update the specified Status in storage.
     * PUT/PATCH /statuses/{id}
     *
     * @param LegalEntity $statuses
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(LegalEntity::$rules);
        /** @var LegalEntity $entities */
        $entities = LegalEntity::find($id);

        if (empty($entities)) {
            return $this->sendError('Entity not found');
        }

        $entities->fill($input);
        $entities->save();

        return $entities;
    }

    /**
     * Remove the specified Status from storage.
     * DELETE /statuses/{id}
     *
     * @param LegalEntity $entities
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var LegalEntity $entities */
        $entities = LegalEntity::find($id);

        if (empty($entities)) {
            return $this->sendError('Entity not found');
        }

        $entities->delete();

        return $this->sendSuccess('Entity deleted successfully');
    }
}
