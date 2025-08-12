<?php

namespace App\Http\Controllers\API;


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
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = BagHoroo::filter( $request->all(["search", ...BagHoroo::$searchIn]))->with('soum_district:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $bagHoroos = $query->get();

        return $bagHoroos->toJson();
    }

    /**
     * Store a newly created BagHoroo in storage.
     * POST /bagHoroos
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(BagHoroo::$rules);

        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::create($input);

        return $bagHoroo->toJson();
    }

    /**
     * Display the specified BagHoroo.
     * GET|HEAD /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::find($id);

        if (empty($bagHoroo)) {
            return $this->sendError('Bag Horoo not found');
        }

        return $bagHoroo->toJson();
    }

    /**
     * Update the specified BagHoroo in storage.
     * PUT/PATCH /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(BagHoroo::$rules);
        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::find($id);

        if (empty($bagHoroo)) {
            return $this->sendError('Bag Horoo not found');
        }

        $bagHoroo->fill($input);
        $bagHoroo->save();

        return $bagHoroo->toJson();
    }

    /**
     * Remove the specified BagHoroo from storage.
     * DELETE /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
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
