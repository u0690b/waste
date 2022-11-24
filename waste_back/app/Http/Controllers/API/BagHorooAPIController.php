<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBagHorooAPIRequest;
use App\Http\Requests\API\UpdateBagHorooAPIRequest;
use App\Models\BagHoroo;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class BagHorooController
 * @package App\Http\Controllers\API
 */

class BagHorooAPIController extends AppBaseController
{
    /**
     * Display a listing of the BagHoroo.
     * GET|HEAD /bagHoroos
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = BagHoroo::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $bagHoroos = $query->get();

        return $this->sendResponse($bagHoroos->toArray(), 'Bag Horoos retrieved successfully');
    }

    /**
     * Store a newly created BagHoroo in storage.
     * POST /bagHoroos
     *
     * @return Response
     */
    public function store(CreateBagHorooAPIRequest $request)
    {
        $input = $request->all();

        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::create($input);

        return $this->sendResponse($bagHoroo->toArray(), 'Bag Horoo saved successfully');
    }

    /**
     * Display the specified BagHoroo.
     * GET|HEAD /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::find($id);

        if (empty($bagHoroo)) {
            return $this->sendError('Bag Horoo not found');
        }

        return $this->sendResponse($bagHoroo->toArray(), 'Bag Horoo retrieved successfully');
    }

    /**
     * Update the specified BagHoroo in storage.
     * PUT/PATCH /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @return Response
     */
    public function update($id, UpdateBagHorooAPIRequest $request)
    {
        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::find($id);

        if (empty($bagHoroo)) {
            return $this->sendError('Bag Horoo not found');
        }

        $bagHoroo->fill($request->all());
        $bagHoroo->save();

        return $this->sendResponse($bagHoroo->toArray(), 'BagHoroo updated successfully');
    }

    /**
     * Remove the specified BagHoroo from storage.
     * DELETE /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::find($id);

        if (empty($bagHoroo)) {
            return $this->sendError('Bag Horoo not found');
        }

        $bagHoroo->delete();

        return $this->sendSuccess('Bag Horoo deleted successfully');
    }
}
